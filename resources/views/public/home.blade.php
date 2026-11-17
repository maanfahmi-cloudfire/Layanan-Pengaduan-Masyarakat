@extends('layouts.public')

@section('title', 'Beranda - Layanan Pengaduan Masyarakat Gayo Lues')

@section('content')
    <!-- 1. Hero Section with Gayo Lues Landscape Background -->
    <section class="relative bg-slate-900 bg-cover bg-center bg-no-repeat pt-20 pb-28 overflow-hidden border-b border-slate-200" style="background-image: url('{{ asset('images/gayo-lues-hero.jpg') }}');">
        <!-- Elegant Dark & Emerald Gradient Overlay for optimal contrast & image visibility -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-900/75 to-slate-950/90 backdrop-blur-[0.5px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto space-y-6">
                
                <!-- Badge Wilayah -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-emerald-300 text-xs font-bold tracking-wider uppercase shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Kabupaten Gayo Lues • Negeri Seribu Bukit
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-md">
                    Sampaikan Pengaduan Anda <br class="hidden sm:inline">Demi Kemajuan <span class="text-emerald-400 whitespace-nowrap drop-shadow-sm">Gayo Lues</span>
                </h1>

                <!-- Subheading -->
                <p class="text-base sm:text-lg text-slate-200 leading-relaxed font-normal max-w-2xl mx-auto drop-shadow">
                    Layanan digital terpadu untuk melaporkan kendala infrastruktur, fasilitas publik, kebersihan, dan pelayanan publik di seluruh kecamatan se-Kabupaten Gayo Lues. Cepat, transparan, dan terarah.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="{{ route('complaints.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl shadow-lg shadow-emerald-950/50 hover:shadow-emerald-500/30 transition-all hover:-translate-y-0.5">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                        Buat Pengaduan Sekarang
                    </a>
                    <a href="{{ route('track') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 text-base font-bold text-white bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 rounded-xl transition-all hover:-translate-y-0.5 shadow-sm">
                        <i data-lucide="search" class="w-5 h-5 text-emerald-400"></i>
                        Lacak Status Pengaduan
                    </a>
                </div>

                <!-- Quick Tracking Bar -->
                <div class="pt-6 max-w-xl mx-auto">
                    <form action="{{ route('track') }}" method="GET" class="relative flex items-center bg-white/95 backdrop-blur-md p-1.5 rounded-2xl shadow-2xl border border-white/40">
                        <i data-lucide="ticket" class="w-5 h-5 text-slate-400 absolute left-4 pointer-events-none"></i>
                        <input type="text" name="ticket" placeholder="Punya nomor tiket? Contoh: GL-2026-000001" class="w-full pl-11 pr-28 py-3 bg-transparent text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-0 font-medium" required>
                        <button type="submit" class="absolute right-2 px-5 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl transition-colors shadow-sm">
                            Lacak
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Statistics Section -->
    <section class="py-12 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Stat 1: Total Pengaduan -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-brand-100 text-brand-800 flex items-center justify-center shrink-0">
                        <i data-lucide="layers" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-brand-900">{{ number_format($stats['total']) }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-0.5">Total Pengaduan</div>
                    </div>
                </div>

                <!-- Stat 2: Menunggu Verifikasi -->
                <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                        <i data-lucide="clock" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-amber-900">{{ number_format($stats['menunggu']) }}</div>
                        <div class="text-xs font-semibold text-amber-700 uppercase tracking-wider mt-0.5">Menunggu Verifikasi</div>
                    </div>
                </div>

                <!-- Stat 3: Sedang Diproses -->
                <div class="p-6 rounded-2xl bg-blue-50/60 border border-blue-200 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center shrink-0">
                        <i data-lucide="refresh-cw" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-blue-900">{{ number_format($stats['diproses']) }}</div>
                        <div class="text-xs font-semibold text-blue-700 uppercase tracking-wider mt-0.5">Sedang Diproses</div>
                    </div>
                </div>

                <!-- Stat 4: Selesai Ditangani -->
                <div class="p-6 rounded-2xl bg-emerald-50/60 border border-emerald-200 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                        <i data-lucide="check-check" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-emerald-900">{{ number_format($stats['selesai']) }}</div>
                        <div class="text-xs font-semibold text-emerald-700 uppercase tracking-wider mt-0.5">Selesai Ditangani</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Kategori Pengaduan -->
    <section class="py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600">Bidang Laporan</span>
                <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Kategori Pengaduan Masyarakat</h2>
                <p class="text-slate-600 text-sm mt-3">Pilihlah klasifikasi laporan sesuai dengan permasalahan yang Anda temui di lingkungan sekitar.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $cat)
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-brand-300 hover:shadow-md transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                            <i data-lucide="{{ $cat->icon ?: 'folder' }}" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">{{ $cat->name }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed mb-4">{{ Str::limit($cat->description, 85) }}</p>
                        <div class="flex items-center justify-between text-xs font-semibold text-brand-600 border-t border-slate-100 pt-3">
                            <span>{{ $cat->complaints_count }} Laporan Masuk</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. Cara Menggunakan Layanan (Alur Sistem) -->
    <section class="py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600">Alur Pengaduan</span>
                <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Bagaimana Sistem Bekerja?</h2>
                <p class="text-slate-600 text-sm mt-3">Proses pengaduan yang mudah, terstruktur, dan akuntabel dalam 4 langkah sederhana.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Step 1 -->
                <div class="relative text-center p-6 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-full bg-brand-900 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-base shadow">1</div>
                    <h4 class="font-bold text-slate-900 text-base mb-2">Daftar & Masuk</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Masyarakat membuat akun menggunakan data nama, no HP, serta asal kecamatan dan desa di Gayo Lues.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center p-6 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-full bg-brand-600 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-base shadow">2</div>
                    <h4 class="font-bold text-slate-900 text-base mb-2">Kirim Laporan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Tulis rincian keluhan, pilih kategori, tentukan lokasi kejadian, serta lampirkan foto bukti autentik.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative text-center p-6 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-full bg-accent-500 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-base shadow">3</div>
                    <h4 class="font-bold text-slate-900 text-base mb-2">Verifikasi & Proses</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Admin memverifikasi keabsahan laporan dan meneruskannya ke dinas/pihak terkait untuk ditindaklanjuti.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="relative text-center p-6 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-full bg-emerald-700 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-base shadow">4</div>
                    <h4 class="font-bold text-slate-900 text-base mb-2">Tanggapan & Selesai</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Warga memantau perkembangan status secara real-time dan menerima jawaban resmi hingga tuntas.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. Laporan Publik Terbaru (Data Terverifikasi) -->
    <section class="py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600">Transparansi Publik</span>
                    <h2 class="text-3xl font-extrabold text-brand-900 mt-1">Laporan Terkini di Gayo Lues</h2>
                    <p class="text-slate-600 text-sm mt-2">Daftar pengaduan yang telah diverifikasi dan sedang/selesai ditindaklanjuti.</p>
                </div>
                <a href="{{ route('track') }}" class="mt-4 md:mt-0 inline-flex items-center gap-1.5 text-sm font-bold text-brand-600 hover:text-brand-800">
                    <span>Lacak Pengaduan Spesifik</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($recentComplaints as $complaint)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-md transition-all">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 text-xs font-mono font-bold bg-slate-100 text-slate-700 rounded-md">
                                    {{ $complaint->ticket_number }}
                                </span>
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $complaint->status_badge_class }}">
                                    {{ $complaint->status_label }}
                                </span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-base mb-2 line-clamp-2">
                                {{ $complaint->title }}
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-3 mb-4 leading-relaxed">
                                {{ $complaint->description }}
                            </p>
                        </div>
                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between text-xs text-slate-500">
                            <span class="flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-600"></i>
                                Kec. {{ $complaint->kecamatan }}
                            </span>
                            <span>{{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-slate-200">
                        <i data-lucide="inbox" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                        <h4 class="text-base font-bold text-slate-700">Belum ada pengaduan publik yang diverifikasi</h4>
                        <p class="text-xs text-slate-500 mt-1">Laporan yang masuk akan tampil di sini setelah lolos tahap verifikasi admin.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 6. FAQ (Pertanyaan yang Sering Diajukan) -->
    <section class="py-20 bg-white" x-data="{ activeFaq: null }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600">Pusat Informasi</span>
                <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                <p class="text-slate-600 text-sm mt-3">Temukan jawaban cepat terkait cara penggunaan dan alur layanan pengaduan warga.</p>
            </div>

            <div class="space-y-4">
                
                <!-- FAQ 1 -->
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full text-left p-5 flex items-center justify-between font-bold text-slate-900 text-sm focus:outline-none">
                        <span>Apakah saya harus mendaftar akun terlebih dahulu untuk mengirim pengaduan?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-500 transition-transform duration-200" :class="activeFaq === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 1" x-collapse x-cloak class="px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-200 pt-3 bg-white">
                        Ya. Registrasi akun diperlukan agar setiap pengaduan memiliki identitas pelapor yang jelas dan terhindar dari spam. Selain itu, Anda dapat memantau riwayat seluruh laporan serta tanggapan resmi admin langsung dari dashboard Anda.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full text-left p-5 flex items-center justify-between font-bold text-slate-900 text-sm focus:outline-none">
                        <span>Bagaimana format nomor tiket pengaduan saya?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-500 transition-transform duration-200" :class="activeFaq === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 2" x-collapse x-cloak class="px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-200 pt-3 bg-white">
                        Nomor tiket digenerate otomatis dengan format unik <code>GL-TAHUN-URUTAN</code>, misalnya <code>GL-2026-000001</code>. Nomor tiket ini bersifat unik dan dapat digunakan siapa saja untuk mengecek perkembangan penanganan tanpa membuka data pribadi pelapor.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full text-left p-5 flex items-center justify-between font-bold text-slate-900 text-sm focus:outline-none">
                        <span>Berapa lama waktu yang dibutuhkan hingga pengaduan diverifikasi?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-500 transition-transform duration-200" :class="activeFaq === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 3" x-collapse x-cloak class="px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-200 pt-3 bg-white">
                        Proses verifikasi oleh admin dilakukan dalam 1–2 hari kerja setelah laporan dikirim. Apabila laporan memenuhi syarat, status akan berubah menjadi "Diverifikasi" dan dilanjutkan ke instansi terkait.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <button @click="activeFaq = activeFaq === 4 ? null : 4" class="w-full text-left p-5 flex items-center justify-between font-bold text-slate-900 text-sm focus:outline-none">
                        <span>Mengapa laporan saya ditolak?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-500 transition-transform duration-200" :class="activeFaq === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 4" x-collapse x-cloak class="px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-200 pt-3 bg-white">
                        Laporan dapat ditolak apabila: informasi tidak jelas, bukan merupakan ranah pelayanan publik (misalnya sengketa perdata keluarga pribadi), atau mengandung ujaran kebencian/SARA. Alasan penolakan resmi dapat Anda lihat secara transparan pada rincian laporan Anda.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. Call To Action Banner -->
    <section class="py-16 bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 text-white text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-3xl font-extrabold">Ada Masalah Pelayanan Publik di Lingkungan Anda?</h2>
            <p class="text-slate-300 text-sm max-w-xl mx-auto leading-relaxed">
                Jangan biarkan jalan rusak, sampah menumpuk, atau kendala fasilitas umum berlarut-larut. Laporkan segera agar ditangani oleh pihak berwenang.
            </p>
            <div class="pt-2">
                <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-xl shadow-lg transition-all hover:scale-105">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Kirim Pengaduan Sekarang
                </a>
            </div>
        </div>
    </section>
@endsection

