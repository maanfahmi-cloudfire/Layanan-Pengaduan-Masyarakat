@extends('layouts.public')

@section('title', 'Tentang Layanan - Layanan Pengaduan Masyarakat Gayo Lues')

@section('content')
    <!-- Header Banner -->
    <section class="bg-gradient-to-b from-brand-50 to-white py-16 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600">Tentang Sistem</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-900 mt-2">Mewujudkan Pelayanan Publik Gayo Lues yang Terbuka & Responsif</h1>
            <p class="text-slate-600 text-sm mt-4 leading-relaxed">
                Inisiatif platform berbasis teknologi web untuk menghubungkan aspirasi masyarakat di seluruh pelosok Kabupaten Gayo Lues dengan proses penanganan yang transparan.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            
            <!-- Latar Belakang -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <div class="space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-accent-600 bg-accent-50 px-3 py-1 rounded-full">Latar Belakang</span>
                    <h2 class="text-2xl font-bold text-slate-900">Inspirasi Dari Konsep SP4N-LAPOR! Untuk Skala Daerah</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kabupaten Gayo Lues memiliki kondisi geografis perbukitan dengan 11 kecamatan yang tersebar dari Blangkejeren hingga wilayah terjauh seperti Terangun dan Pining. Akses penyampaian keluhan pelayanan publik secara konvensional seringkali memakan waktu dan biaya transportasi bagi warga desa.
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Aplikasi ini dikembangkan untuk mendigitalisasi mekanisme pengaduan masyarakat secara ringkas, sehingga setiap warga dapat melaporkan kondisi darurat atau ketidaksesuaian fasilitas hanya dengan genggaman smartphone.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-brand-900 to-brand-800 p-8 rounded-3xl text-white shadow-xl space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-6 h-6 text-brand-200"></i>
                    </div>
                    <h3 class="text-xl font-bold">Integritas & Akuntabilitas</h3>
                    <p class="text-xs text-brand-100 leading-relaxed">
                        Setiap laporan memiliki nomor tiket resmi yang tidak dapat diubah (immutable track record), dilengkapi lini masa status dari verifikasi awal hingga penyelesaian akhir.
                    </p>
                </div>
            </div>

            <!-- Tujuan & Manfaat -->
            <div>
                <h3 class="text-xl font-bold text-slate-900 text-center mb-8">Tujuan & Manfaat Utama</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-800 flex items-center justify-center">
                            <i data-lucide="zap" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Respons Cepat</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Mempercepat arus informasi dari masyarakat langsung ke meja verifikator tanpa hambatan birokrasi manual.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Transparansi Nyata</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Status pengerjaan, alasan penolakan, serta jawaban resmi instansi dapat dipantau langsung oleh pelapor dan publik.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center">
                            <i data-lucide="database" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Data Pembangunan</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Menghasilkan statistik titik permasalahan per kecamatan yang dapat diunduh untuk analisis perbaikan layanan daerah.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Disclaimer Box -->
            <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-900 leading-relaxed flex items-start gap-4">
                <i data-lucide="info" class="w-6 h-6 text-amber-700 shrink-0 mt-0.5"></i>
                <div>
                    <h5 class="font-bold text-sm text-amber-950 mb-1">Pernyataan Status Proyek Akademik (Disclaimer)</h5>
                    <p>
                        Aplikasi web <strong>Layanan Pengaduan Masyarakat Gayo Lues</strong> ini dirancang dan dibangun sebagai proyek Ujian Akhir Semester (UAS) mahasiswa dan portofolio profesional software engineering. Aplikasi ini tidak berafiliasi resmi atau mengatasnamakan Pemerintah Daerah Kabupaten Gayo Lues secara hukum. Seluruh data demonstrasi yang ditampilkan merupakan simulasi untuk keperluan evaluasi sistem informasi.
                    </p>
                </div>
            </div>

        </div>
    </section>
@endsection

