# LAYANAN PENGADUAN MASYARAKAT GAYO LUES
### Sistem Informasi Pengaduan Pelayanan Publik Berbasis Web
**Teknologi: PHP 8.3 • Laravel 12/13 • MySQL/SQLite • Tailwind CSS • Lucide Icons • Chart.js**

Aplikasi ini merupakan sistem informasi pengaduan masyarakat berbasis web yang terinspirasi dari konsep SP4N-LAPOR!, dirancang khusus dalam skala daerah untuk masyarakat Kabupaten Gayo Lues, Provinsi Aceh. Dikembangkan sebagai proyek Ujian Akhir Semester (UAS) dan portofolio profesional yang siap dideploy ke Ubuntu VPS.

---

## 🏛️ Fitur Utama Aplikasi

### 1. Halaman Publik
- **Beranda (Homepage):** Hero section dengan identitas Kabupaten Gayo Lues (Negeri Seribu Bukit), counter statistik real-time, kategori pengaduan, panduan 4 langkah sistem, laporan terkini yang diverifikasi, dan FAQ interaktif.
- **Lacak Pengaduan (Pelacakan Terbuka):** Pencarian status menggunakan nomor tiket (contoh: `GL-2026-000001`). Informasi privasi pelapor (kontak & email) disensor demi keamanan.
- **Tentang Layanan:** Latar belakang, tujuan, manfaat, dan disclaimer independen.
- **Panduan Penggunaan:** Petunjuk registrasi, pembuatan laporan, dan pemantauan tindak lanjut.

### 2. Aktor Masyarakat (Warga)
- **Registrasi Akun:** Dilengkapi pilihan 11 kecamatan dan nama desa di Kabupaten Gayo Lues.
- **Login & Logout:** Dilengkapi pengalihan otomatis berdasarkan role.
- **Dashboard Masyarakat:** 4 Kartu metrik status, riwayat laporan terkini, dan tombol pengaduan cepat.
- **Formulir Pengaduan:** Input judul, kategori, deskripsi lengkap, lokasi spesifik, kecamatan, desa, tanggal kejadian, dan upload foto bukti (maksimal 3MB).
- **Generator Nomor Tiket Otomatis:** Format unik `GL-YYYY-XXXXXX` aman terhadap duplikasi concurrent via database lock.
- **Riwayat & Detail Pengaduan:** Timeline riwayat perubahan status, preview foto bukti, alasan penolakan (jika ditolak), dan tanggapan resmi dari pihak administrator.
- **Proteksi Akses:** Warga hanya dapat mengakses laporan miliknya sendiri (Authorization Check).

### 3. Aktor Administrator
- **Dashboard Analitik & Grafik:**
  - 7 Kartu metrik (Total Laporan, Warga Terdaftar, Menunggu Verifikasi, Diverifikasi, Sedang Diproses, Selesai, Ditolak).
  - Grafik Donat Distribusi Pengaduan per Kategori (Chart.js).
  - Grafik Garis Tren Volume Pengaduan per Bulan (Chart.js).
  - Grafik Batang Sebaran Pengaduan pada 11 Kecamatan di Gayo Lues (Chart.js).
- **Manajemen Pengaduan:** Filter lengkap berdasarkan nomor tiket, judul, pelapor, kategori, kecamatan, dan status.
- **Verifikasi Laporan:** Mengubah status dari Menunggu Verifikasi menjadi Diverifikasi.
- **Penolakan Laporan:** Menolak pengaduan dengan input alasan wajib yang transparan bagi pelapor.
- **Pembaruan Status Penanganan:** Mengubah status menjadi Sedang Diproses atau Selesai beserta catatan proses.
- **Tanggapan Resmi:** Menulis tanggapan atau solusi tindak lanjut pemerintah daerah.
- **Manajemen Kategori (CRUD):** Tambah, edit, aktifkan/nonaktifkan kategori, dan proteksi penghapusan data jika kategori telah terikat pada pengaduan.
- **Laporan & Rekapitulasi:**
  - Filter periode tanggal kejadian, kategori, kecamatan, dan status.
  - Ringkasan metrik hasil filter.
  - Cetak dokumen resmi format print / PDF dengan kop pengaduan dan lembar tanda tangan pengesahan.
  - Ekspor seluruh data ke format Excel / CSV (support UTF-8 BOM).

---

## 👥 Akun Simulasi Pengujian (Demo)

Untuk keperluan pengujian UAS dan penilaian, tersedia akun yang sudah disiapkan melalui seeder:

| Role | Email | Password | Keterangan |
|------|-------|----------|------------|
| **Admin Utama** | `admin@gayolues.go.id` | `password123` | Akses penuh Panel Admin, verifikasi, statistik, dan rekapitulasi |
| **Masyarakat 1** | `warga1@gayolues.id` | `password123` | Warga Kec. Blangkejeren (memiliki beberapa riwayat laporan) |
| **Masyarakat 2** | `warga2@gayolues.id` | `password123` | Warga Kec. Kutapanjang |

*(Catatan: Tombol cepat auto-fill akun demo juga tersedia di halaman Login).*

---

## 🛠️ Instalasi & Menjalankan di Lokal

### 1. Masuk ke direktori proyek:
```bash
cd C:\Users\Lenovo\.gemini\antigravity\scratch\pengaduan-gayo-lues
```

### 2. Jalankan migrasi dan seeder:
```bash
php artisan migrate:fresh --seed
```

### 3. Jalankan server lokal:
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

### 4. Menjalankan Unit & Feature Testing:
```bash
php artisan test
```

---

## 🚀 Panduan Deployment VPS Ubuntu

Panduan lengkap instalasi Ubuntu Server, Nginx, PHP 8.3 FPM, MySQL, SSL HTTPS Certbot, dan automasi deployment dapat dibaca pada file:
👉 **[DEPLOYMENT-VPS-UBUNTU.md](DEPLOYMENT-VPS-UBUNTU.md)**
