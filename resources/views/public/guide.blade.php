@extends('layouts.public')

@section('title', 'Panduan Penggunaan - Layanan Pengaduan Masyarakat Gayo Lues')

@section('content')
    <!-- Header Banner -->
    <section class="bg-gradient-to-b from-brand-50 to-white py-16 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600">Panduan Praktis</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-900 mt-2">Panduan Lengkap Penggunaan Layanan</h1>
            <p class="text-slate-600 text-sm mt-4 leading-relaxed">
                Pelajari langkah demi langkah mulai dari membuat akun, menyusun formulir pengaduan yang efektif, hingga melacak perkembangan laporan Anda.
            </p>
        </div>
    </section>

    <!-- Content Sections -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Panduan 1: Registrasi Akun -->
            <div class="border border-slate-200 rounded-2xl p-8 bg-slate-50 relative overflow-hidden">
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 rounded-xl bg-brand-900 text-white font-extrabold flex items-center justify-center text-sm">
                        01
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Cara Mendaftar Akun Masyarakat</h3>
                </div>
                <div class="space-y-3 text-sm text-slate-600 leading-relaxed pl-14">
                    <p>1. Klik tombol <strong>"Daftar Akun"</strong> pada pojok kanan atas halaman website.</p>
                    <p>2. Isi formulir dengan data diri yang benar:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs text-slate-700 bg-white p-4 rounded-xl border border-slate-200">
                        <li><strong>Nama Lengkap:</strong> Sesuai identitas KTP.</li>
                        <li><strong>Email Aktif:</strong> Digunakan untuk masuk sistem.</li>
                        <li><strong>Nomor HP/WhatsApp:</strong> Agar admin dapat mengklarifikasi jika diperlukan.</li>
                        <li><strong>Kecamatan & Desa:</strong> Pilih domisili Anda di Kabupaten Gayo Lues.</li>
                        <li><strong>Password:</strong> Minimal 8 karakter kombinasi huruf dan angka.</li>
                    </ul>
                    <p>3. Tekan tombol <strong>"Daftar Sekarang"</strong>. Akun Anda akan langsung aktif dan dialihkan ke dashboard.</p>
                </div>
            </div>

            <!-- Panduan 2: Membuat Pengaduan -->
            <div class="border border-slate-200 rounded-2xl p-8 bg-slate-50 relative overflow-hidden">
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 rounded-xl bg-brand-600 text-white font-extrabold flex items-center justify-center text-sm">
                        02
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Cara Mengirimkan Pengaduan</h3>
                </div>
                <div class="space-y-3 text-sm text-slate-600 leading-relaxed pl-14">
                    <p>1. Pastikan Anda telah <strong>Masuk (Login)</strong> ke akun Anda.</p>
                    <p>2. Klik tombol <strong>"Buat Pengaduan"</strong> pada dashboard atau navbar utama.</p>
                    <p>3. Lengkapi formulir pengaduan dengan detail yang jelas:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs text-slate-700 bg-white p-4 rounded-xl border border-slate-200">
                        <li><strong>Judul Pengaduan:</strong> Ringkasan singkat permasalahan (contoh: <em>Pipa Air Bocor di Jalan Blangkejeren Km 2</em>).</li>
                        <li><strong>Kategori:</strong> Sesuaikan bidang keluhan (Infrastruktur, Air Bersih, Kesehatan, dll).</li>
                        <li><strong>Deskripsi Rincian:</strong> Ceritakan kronologi kejadian dan dampak yang dialami masyarakat sekitar.</li>
                        <li><strong>Kecamatan & Desa:</strong> Lokasi persis kejadian perkara.</li>
                        <li><strong>Tanggal Kejadian:</strong> Kapan permasalahan tersebut mulai terjadi atau ditemukan.</li>
                        <li><strong>Foto Bukti (Opsional namun sangat disarankan):</strong> Lampirkan foto kondisi nyata di lapangan (format JPG/PNG maks 3MB).</li>
                    </ul>
                    <p>4. Klik <strong>"Kirim Pengaduan"</strong>. Sistem akan menerbitkan <strong>Nomor Tiket</strong> otomatis.</p>
                </div>
            </div>

            <!-- Panduan 3: Memantau Status & Tanggapan -->
            <div class="border border-slate-200 rounded-2xl p-8 bg-slate-50 relative overflow-hidden">
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 rounded-xl bg-accent-500 text-white font-extrabold flex items-center justify-center text-sm">
                        03
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Memantau Status & Tanggapan Resmi</h3>
                </div>
                <div class="space-y-3 text-sm text-slate-600 leading-relaxed pl-14">
                    <p>Setelah pengaduan terkirim, Anda dapat memantau proses penyelesaian melalui:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-2">
                        <div class="bg-white p-4 rounded-xl border border-slate-200">
                            <h5 class="font-bold text-slate-800 text-xs uppercase mb-1">Melalui Dashboard Akun</h5>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Buka menu <strong>"Riwayat Pengaduan"</strong> untuk melihat detail riwayat, status verifikasi, dan balasan resmi admin secara lengkap.
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200">
                            <h5 class="font-bold text-slate-800 text-xs uppercase mb-1">Melalui Halaman Lacak Publik</h5>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Buka menu <strong>"Lacak Pengaduan"</strong>, lalu masukkan nomor tiket (contoh: <code>GL-2026-000001</code>). Data ditampilkan tanpa membocorkan privasi Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hubungi Bantuan -->
            <div class="text-center pt-8 border-t border-slate-200">
                <p class="text-sm text-slate-600 mb-4">Sudah siap menyampaikan keluhan pelayanan publik?</p>
                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-900 hover:bg-brand-800 text-white text-sm font-bold rounded-xl shadow transition-colors">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Mulai Buat Pengaduan
                    </a>
                </div>
            </div>

        </div>
    </section>
@endsection

