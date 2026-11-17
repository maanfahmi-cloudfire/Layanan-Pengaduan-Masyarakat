@extends('layouts.masyarakat')

@section('title', 'Dashboard Warga')

@section('content')
    <!-- Welcome Header Banner with Gayo Lues Landscape -->
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 text-white mb-8 shadow-xl shadow-brand-900/10 flex flex-col sm:flex-row sm:items-center justify-between gap-6 bg-cover bg-center" style="background-image: url('{{ asset('images/gayo-lues-hero.jpg') }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-brand-950/95 via-brand-900/90 to-slate-950/85"></div>
        
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-300 text-xs font-semibold backdrop-blur-md border border-white/10">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Domisili: {{ auth()->user()->desa }}, Kec. {{ auth()->user()->kecamatan }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Halo, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-xs sm:text-sm text-slate-200 max-w-xl leading-relaxed">
                Selamat datang di sistem layanan pengaduan Gayo Lues. Pantau perkembangan laporan Anda atau sampaikan aspirasi dan kendala baru di lingkungan Anda.
            </p>
        </div>
        <div class="relative z-10 shrink-0">
            <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2.5 px-6 py-3.5 bg-accent-500 hover:bg-accent-600 text-white text-sm font-bold rounded-2xl shadow-lg transition-all hover:scale-105">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                Buat Pengaduan Baru
            </a>
        </div>
    </div>

    <!-- 4 Kartu Statistik Ringkas -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        
        <!-- Total -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                <i data-lucide="layers" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $stats['total'] }}</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-0.5">Total Laporan</div>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-amber-900">{{ $stats['menunggu'] }}</div>
                <div class="text-xs font-semibold text-amber-700 uppercase tracking-wider mt-0.5">Menunggu Verifikasi</div>
            </div>
        </div>

        <!-- Sedang Diproses -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-blue-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                <i data-lucide="refresh-cw" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-blue-900">{{ $stats['diproses'] }}</div>
                <div class="text-xs font-semibold text-blue-700 uppercase tracking-wider mt-0.5">Sedang Diproses</div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-emerald-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                <i data-lucide="check-check" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-900">{{ $stats['selesai'] }}</div>
                <div class="text-xs font-semibold text-emerald-700 uppercase tracking-wider mt-0.5">Selesai Ditangani</div>
            </div>
        </div>

    </div>

    <!-- Riwayat Pengaduan Terbaru -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Riwayat Pengaduan Terbaru Anda</h3>
                <p class="text-xs text-slate-400 mt-0.5">Pantau status laporan terkini yang telah Anda kirimkan.</p>
            </div>
            <a href="{{ route('complaints.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-800 flex items-center gap-1">
                <span>Lihat Semua</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        @if($recentComplaints->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($recentComplaints as $c)
                    <div class="p-5 sm:p-6 hover:bg-slate-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1.5 max-w-2xl">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-xs bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md">
                                    {{ $c->ticket_number }}
                                </span>
                                <span class="text-xs text-slate-400">•</span>
                                <span class="text-xs font-semibold text-brand-600">{{ $c->category->name }}</span>
                                <span class="text-xs text-slate-400">•</span>
                                <span class="text-xs text-slate-400">{{ $c->created_at->format('d M Y') }}</span>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 leading-snug">
                                <a href="{{ route('complaints.show', $c->id) }}" class="hover:text-brand-600 transition-colors">
                                    {{ $c->title }}
                                </a>
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-1 leading-relaxed">
                                {{ $c->description }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $c->status_badge_class }}">
                                {{ $c->status_label }}
                            </span>
                            <a href="{{ route('complaints.show', $c->id) }}" class="p-2 text-slate-400 hover:text-brand-600 hover:bg-white rounded-lg transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <i data-lucide="inbox" class="w-8 h-8"></i>
                </div>
                <h4 class="text-base font-bold text-slate-800">Belum Ada Pengaduan</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Anda belum pernah membuat laporan pengaduan. Sampaikan keluhan pelayanan publik di sekitar Anda sekarang.
                </p>
                <div class="pt-2">
                    <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Buat Pengaduan Pertama
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

