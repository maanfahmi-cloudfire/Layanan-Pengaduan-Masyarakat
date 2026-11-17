@extends('layouts.public')

@section('title', 'Lacak Status Pengaduan - Layanan Pengaduan Masyarakat Gayo Lues')

@section('content')
    <!-- Header Banner -->
    <section class="bg-gradient-to-b from-brand-50 to-white py-12 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-2xl">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600">Pelacakan Terbuka</span>
            <h1 class="text-3xl font-extrabold text-brand-900 mt-2">Lacak Perkembangan Pengaduan</h1>
            <p class="text-slate-600 text-sm mt-3">
                Masukkan nomor tiket laporan Anda untuk mengetahui perkembangan penanganan oleh pihak terkait secara transparan.
            </p>

            <!-- Search Ticket Form -->
            <form action="{{ route('track') }}" method="GET" class="mt-8 max-w-lg mx-auto">
                <div class="flex items-center bg-white p-2 rounded-2xl border-2 border-slate-300 focus-within:border-brand-600 focus-within:ring-2 focus-within:ring-brand-100 shadow-sm transition-all">
                    <i data-lucide="ticket" class="w-6 h-6 text-slate-400 ml-3 shrink-0"></i>
                    <input type="text" name="ticket" value="{{ $ticket }}" placeholder="Masukkan Nomor Tiket (Contoh: GL-2026-000001)" class="w-full px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none uppercase font-semibold" required>
                    <button type="submit" class="px-6 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl transition-colors shrink-0">
                        Cari Tiket
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Result Section -->
    <section class="py-12 bg-slate-50 min-h-[500px]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(!empty($ticket) && !$complaint)
                <!-- Not Found State -->
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-lg mx-auto space-y-4 shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mx-auto">
                        <i data-lucide="search-x" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Nomor Tiket Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pengaduan dengan nomor tiket <span class="font-mono font-bold text-slate-800">"{{ $ticket }}"</span> tidak terdaftar dalam database kami. Pastikan format nomor tiket benar (contoh: <code>GL-2026-000001</code>).
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('track') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:underline">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                            Reset Pencarian
                        </a>
                    </div>
                </div>

            @elseif($complaint)
                <!-- Found Result View -->
                <div class="space-y-6">
                    
                    <!-- Main Ticket Info Card -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                        
                        <!-- Top Bar: Ticket & Status -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6 mb-6">
                            <div>
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor Tiket Pengaduan</span>
                                <div class="text-2xl font-black font-mono text-brand-900 tracking-wide mt-0.5">
                                    {{ $complaint->ticket_number }}
                                </div>
                            </div>
                            <div>
                                <span class="px-4 py-1.5 text-xs font-bold rounded-full border {{ $complaint->status_badge_class }}">
                                    {{ $complaint->status_label }}
                                </span>
                            </div>
                        </div>

                        <!-- Complaint Details -->
                        <div class="space-y-6">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 leading-snug">
                                    {{ $complaint->title }}
                                </h2>
                                <p class="text-sm text-slate-600 mt-3 leading-relaxed whitespace-pre-line">
                                    {{ $complaint->description }}
                                </p>
                            </div>

                            <!-- Meta Grid (Privasi pelapor terjaga) -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs">
                                <div>
                                    <span class="text-slate-400 block font-medium">Kategori</span>
                                    <span class="font-bold text-slate-800 mt-0.5 block">{{ $complaint->category->name }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Wilayah</span>
                                    <span class="font-bold text-slate-800 mt-0.5 block">Kec. {{ $complaint->kecamatan }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Desa / Lokasi</span>
                                    <span class="font-bold text-slate-800 mt-0.5 block">{{ $complaint->desa }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Tanggal Masuk</span>
                                    <span class="font-bold text-slate-800 mt-0.5 block">{{ $complaint->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Catatan Perlindungan Data Pribadi -->
                            <div class="flex items-center gap-2 text-xs text-slate-500 bg-brand-50/50 p-3 rounded-xl border border-brand-100">
                                <i data-lucide="lock" class="w-4 h-4 text-brand-600 shrink-0"></i>
                                <span>Informasi kontak pribadi pelapor dilindungi dan tidak ditampilkan pada halaman pelacakan publik.</span>
                            </div>

                            @if($complaint->status === \App\Models\Complaint::STATUS_DITOLAK && $complaint->rejection_reason)
                                <!-- Alert Penolakan -->
                                <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-900 space-y-2">
                                    <div class="flex items-center gap-2 font-bold text-rose-800 text-sm">
                                        <i data-lucide="alert-octagon" class="w-5 h-5"></i>
                                        <span>Alasan Penolakan Laporan:</span>
                                    </div>
                                    <p class="leading-relaxed pl-7">
                                        {{ $complaint->rejection_reason }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline Riwayat Status -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                        <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <i data-lucide="history" class="w-5 h-5 text-brand-600"></i>
                            Timeline Perkembangan Status
                        </h3>

                        <div class="relative pl-6 space-y-8 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                            @forelse($complaint->statusHistories as $history)
                                <div class="relative">
                                    <!-- Bullet Marker -->
                                    <div class="absolute -left-6 top-1 w-5 h-5 rounded-full border-2 border-white bg-brand-600 shadow-sm"></div>
                                    
                                    <div class="space-y-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                            <span class="text-xs font-bold text-slate-800">
                                                Status: {{ $history->new_status_label }}
                                            </span>
                                            <span class="text-[11px] text-slate-400">
                                                {{ $history->created_at->format('d M Y, H:i') }} WIB
                                            </span>
                                        </div>
                                        @if($history->note)
                                            <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100 mt-2">
                                                {{ $history->note }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-xs text-slate-500">Belum ada riwayat status tercatat.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tanggapan Resmi Admin -->
                    @if($complaint->responses->count() > 0)
                        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                            <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <i data-lucide="message-square-quote" class="w-5 h-5 text-emerald-600"></i>
                                Tanggapan Resmi
                            </h3>

                            <div class="space-y-4">
                                @foreach($complaint->responses as $resp)
                                    <div class="bg-emerald-50/50 border border-emerald-200/80 p-5 rounded-2xl space-y-2">
                                        <div class="flex items-center justify-between text-xs text-slate-500">
                                            <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                                                <i data-lucide="badge-check" class="w-4 h-4 text-emerald-600"></i>
                                                Administrator Gayo Lues
                                            </span>
                                            <span>{{ $resp->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                                            {{ $resp->response }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            @else
                <!-- Default Initial State -->
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-lg mx-auto space-y-4 shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto">
                        <i data-lucide="search" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Cari Laporan Anda</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Ketikkan nomor tiket yang Anda dapatkan saat mengirim pengaduan (contoh: <code>GL-2026-000001</code>) pada kolom pencarian di atas.
                    </p>
                </div>
            @endif

        </div>
    </section>
@endsection
