# PANDUAN DEPLOYMENT KE UBUNTU VPS
## Layanan Pengaduan Masyarakat Gayo Lues
**Stack: Ubuntu Server 22.04/24.04 LTS + Nginx + PHP 8.3-FPM + MySQL**

Panduan ini disusun secara bertahap dan praktis untuk memudahkan mahasiswa maupun pengembang melakukan deployment aplikasi web ini ke Virtual Private Server (VPS) publik.

---

## 1. Persiapan Server & Update Sistem

Login ke VPS melalui terminal SSH:
```bash
ssh root@IP_VPS_ANDA
```

Perbarui paket repository dan software server:
```bash
sudo apt update && sudo apt upgrade -y
```

---

## 2. Instalasi Nginx Web Server

```bash
sudo apt install nginx -y
sudo systemctl enable nginx
sudo systemctl start nginx
```

---

## 3. Instalasi PHP 8.3 & Ekstensi Laravel

Tambahkan repository PHP Ondřej Surý:
```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
```

Pasang PHP 8.3 beserta ekstensi yang diwajibkan Laravel:
```bash
sudo apt install -y php8.3-fpm php8.3-cli php8.3-mysql php8.3-curl \
php8.3-gd php8.3-mbstring php8.3-xml php8.3-zip php8.3-bcmath \
php8.3-intl php8.3-readline php8.3-sqlite3
```

Verifikasi instalasi PHP:
```bash
php -v
sudo systemctl status php8.3-fpm
```

---

## 4. Instalasi Composer

Unduh dan pasang Composer secara global di server:
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer -V
```

---

## 5. Instalasi & Konfigurasi Database MySQL

Pasang MySQL Server:
```bash
sudo apt install mysql-server -y
sudo systemctl enable mysql
sudo systemctl start mysql
```

Jalankan pengamanan dasar MySQL:
```bash
sudo mysql_secure_installation
```

Buat database dan user khusus untuk aplikasi Pengaduan Gayo Lues:
```bash
sudo mysql -u root -p
```
Di dalam prompt MySQL, ketik perintah SQL berikut:
```sql
CREATE DATABASE pengaduan_gayolues CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'admin_gayolues'@'localhost' IDENTIFIED BY 'PasswordSangatKuat123!#';
GRANT ALL PRIVILEGES ON pengaduan_gayolues.* TO 'admin_gayolues'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## 6. Clone Proyek & Konfigurasi .env Production

Pindahkan direktori ke web root Nginx:
```bash
cd /var/www
sudo git clone https://github.com/USERNAME_ANDA/pengaduan-gayo-lues.git
cd pengaduan-gayo-lues
```

Salin file environment:
```bash
cp .env.example .env
nano .env
```

Sesuaikan parameter `.env` production berikut:
```env
APP_NAME="Layanan Pengaduan Masyarakat Gayo Lues"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://pengaduan.gayolueskab.go.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pengaduan_gayolues
DB_USERNAME=admin_gayolues
DB_PASSWORD=PasswordSangatKuat123!#

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
FILESYSTEM_DISK=public
```

---

## 7. Install Dependencies & Generate Key

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
```

---

## 8. Migrasi Database & Seeding Data Awal

Jalankan migration tabel dan buat user admin awal serta kategori default:
```bash
php artisan migrate --force
php artisan db:seed --force
```

---

## 9. Konfigurasi Symlink Storage & Hak Akses Permission

Hubungkan folder penyimpanan file bukti publik:
```bash
php artisan storage:link
```

Atur kepemilikan folder ke user web server `www-data`:
```bash
sudo chown -R www-data:www-data /var/www/pengaduan-gayo-lues/storage
sudo chown -R www-data:www-data /var/www/pengaduan-gayo-lues/bootstrap/cache
sudo chmod -R 775 /var/www/pengaduan-gayo-lues/storage
sudo chmod -R 775 /var/www/pengaduan-gayo-lues/bootstrap/cache
```

---

## 10. Konfigurasi Nginx Server Block

Buat file konfigurasi virtual host:
```bash
sudo nano /etc/nginx/sites-available/pengaduan-gayolues
```

Tempelkan konfigurasi berikut (sesuaikan `server_name`):
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name pengaduan.gayolueskab.go.id; # Ganti domain Anda
    root /var/www/pengaduan-gayo-lues/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan konfigurasi Nginx dan restart server:
```bash
sudo ln -s /etc/nginx/sites-available/pengaduan-gayolues /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## 11. Konfigurasi Domain & Pasang SSL HTTPS (Let's Encrypt)

1. Arahkan DNS Record domain Anda:
   - Tipe: `A`
   - Nama: `@` atau `pengaduan`
   - Nilai: `IP_ADDRESS_VPS_ANDA`

2. Pasang Certbot SSL:
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d pengaduan.gayolueskab.go.id
```
Pilih opsi pengalihan otomatis ke HTTPS (Redirect HTTP to HTTPS).

---

## 12. Optimasi Cache Production

Jalankan perintah optimasi kecepatan Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 13. Backup Database Otomatis (Cron Job)

Buat skrip backup database:
```bash
sudo mkdir -p /var/backups/mysql
sudo nano /usr/local/bin/backup-pengaduan.sh
```
Isi skrip:
```bash
#!/bin/bash
BACKUP_DIR="/var/backups/mysql"
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u admin_gayolues -pPasswordSangatKuat123!# pengaduan_gayolues | gzip > $BACKUP_DIR/backup_gayolues_$DATE.sql.gz
# Hapus backup lebih dari 14 hari
find $BACKUP_DIR -type f -name "*.gz" -mtime +14 -delete
```
Berikan izin eksekusi:
```bash
sudo chmod +x /usr/local/bin/backup-pengaduan.sh
```
Jadwalkan di cron (setiap jam 02:00 dini hari):
```bash
sudo crontab -e
```
Tambahkan baris:
```cron
0 2 * * * /usr/local/bin/backup-pengaduan.sh
```

---

## 14. Prosedur Update Kode di Masa Depan

Gunakan skrip `deploy.sh` yang telah disediakan di dalam proyek:
```bash
cd /var/www/pengaduan-gayo-lues
bash deploy.sh
```
Skrip tersebut akan otomatis:
1. Mengaktifkan mode maintenance.
2. Melakukan `git pull`.
3. Menginstal dependensi baru.
4. Menjalankan migrasi database.
5. Memperbarui cache route, config, dan views.
6. Memastikan permission folder tetap aman.
7. Mengaktifkan kembali website.

