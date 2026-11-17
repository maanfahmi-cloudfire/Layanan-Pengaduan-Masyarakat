#!/bin/bash
# ==============================================================================
# Skrip Otomatis Update / Deployment Aplikasi Pengaduan Gayo Lues
# Jalankan di VPS: bash deploy.sh
# ==============================================================================

set -e

echo "🚀 Memulai Deployment Aplikasi Layanan Pengaduan Gayo Lues..."

# 1. Aktifkan maintenance mode sementara
php artisan down --message="Aplikasi sedang dalam pemeliharaan rutin. Silakan kembali beberapa saat lagi." || true

# 2. Ambil update kode terbaru dari repository Git
echo "📥 Menarik perubahan kode terbaru dari Git..."
git pull origin main

# 3. Install dependency Composer (Production Only)
echo "📦 Memperbarui dependencies Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 4. Jalankan migrasi database
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# 5. Refresh cache Laravel untuk performa optimal
echo "⚡ Mengoptimalkan cache konfigurasi, routes, dan views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Pastikan symlink storage terhubung
php artisan storage:link || true

# 7. Pastikan permission folder storage dan bootstrap cache aman
echo "🔒 Memperbaiki hak akses permission folder..."
sudo chown -R www-data:www-data /var/www/pengaduan-gayo-lues/storage /var/www/pengaduan-gayo-lues/bootstrap/cache
sudo chmod -R 775 /var/www/pengaduan-gayo-lues/storage /var/www/pengaduan-gayo-lues/bootstrap/cache

# 8. Matikan maintenance mode (Aplikasi Live kembali)
php artisan up

echo "✅ Deployment Berhasil! Aplikasi Layanan Pengaduan Gayo Lues telah live kembali."

