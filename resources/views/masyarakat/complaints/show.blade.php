@extends('layouts.masyarakat')

@section('title', 'Detail Pengaduan ' . $complaint->ticket_number)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Back Link & Top Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <a href="{{ route('complaints.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-600 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Riwayat Pengaduan
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('track', ['ticket' => $complaint->ticket_number]) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-800 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm transition-colors">
                    <i data-lucide="share-2" class="w-3.5 h-3.5"></i>
                    Lihat di Pelacakan Publik
                </a>
            </div>
        </div>

        @if(session('ticket_number'))
            <!-- Alert Berhasil Kirim Tiket Baru -->
            <div class="p-6 bg-emerald-50 border-2 border-emerald-300 rounded-3xl text-emerald-950 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <i data-lucide="check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-emerald-900">Pengaduan Berhasil Terkirim!</h3>
                        <p class="text-xs text-emerald-700 mt-0.5">Nomor tiket resmi pengaduan Anda:</p>
                    </div>
                </div>
                <div class="font-mono font-black text-xl bg-white px-5 py-2.5 rounded-xl border border-emerald-300 text-brand-900 shadow-inner">
                    {{ session('ticket_number') }}
                </div>
            </div>
        @endif

        <!-- Card Rincian Pengaduan -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            
            <!-- Header Card: Nomor Tiket & Status Badge -->
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

            <!-- Konten Laporan -->
            <div class="space-y-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-snug">
                        {{ $complaint->title }}
                    </h2>
                    <p class="text-sm text-slate-700 mt-4 leading-relaxed whitespace-pre-line bg-slate-50/70 p-5 rounded-2xl border border-slate-100">
                        {{ $complaint->description }}
                    </p>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Kategori</span>
                        <span class="font-bold text-slate-800 mt-0.5 block">{{ $complaint->category->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Kecamatan</span>
                        <span class="font-bold text-slate-800 mt-0.5 block">Kec. {{ $complaint->kecamatan }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Desa / Kampung</span>
                        <span class="font-bold text-slate-800 mt-0.5 block">{{ $complaint->desa }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Tanggal Kejadian</span>
                        <span class="font-bold text-slate-800 mt-0.5 block">{{ $complaint->incident_date->format('d/m/Y') }}</span>
                    </div>
                </div>

                <!-- Lokasi Spesifik -->
                <div class="text-xs text-slate-600 flex items-start gap-2 bg-slate-50 p-3 rounded-xl border border-slate-100">
                    <i data-lucide="map-pin" class="w-4 h-4 text-brand-600 shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="text-slate-800">Alamat / Lokasi Spesifik:</strong>
                        <span>{{ $complaint->location }}</span>
                    </div>
                </div>

                <!-- Foto Bukti -->
                @if($complaint->photo_path)
                    <div class="border-t border-slate-100 pt-6">
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4 text-brand-600"></i>
                            Lampiran Foto Bukti Pendukung
                        </h4>
                        <div class="max-w-md">
                            <a href="{{ asset('storage/' . $complaint->photo_path) }}" target="_blank" class="block group relative rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                                <img src="{{ asset('storage/' . $complaint->photo_path) }}" alt="Foto Bukti" class="w-full max-h-72 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-1.5">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                    <span>Lihat Ukuran Penuh</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Jika Laporan Ditolak -->
                @if($complaint->status === \App\Models\Complaint::STATUS_DITOLAK && $complaint->rejection_reason)
                    <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-900 space-y-2">
                        <div class="flex items-center gap-2 font-bold text-rose-800 text-sm">
                            <i data-lucide="alert-octagon" class="w-5 h-5"></i>
                            <span>Laporan Ini Ditolak oleh Administrator:</span>
                        </div>
                        <p class="leading-relaxed pl-7 whitespace-pre-line">
                            {{ $complaint->rejection_reason }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Timeline Riwayat Perkembangan Status -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                <i data-lucide="git-commit" class="w-5 h-5 text-brand-600"></i>
                Timeline Riwayat Perkembangan Status
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
                            <div class="text-[10px] text-slate-400">
                                Dicatat oleh: {{ $history->changer ? $history->changer->name : 'Sistem' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-xs text-slate-500">Belum ada riwayat status tercatat.</div>
                @endforelse
            </div>
        </div>

        <!-- Tanggapan Resmi Admin -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="message-square" class="w-5 h-5 text-emerald-600"></i>
                Tanggapan Resmi Administrator ({{ $complaint->responses->count() }})
            </h3>

            @if($complaint->responses->count() > 0)
                <div class="space-y-4 mt-6">
                    @foreach($complaint->responses as $resp)
                        <div class="bg-emerald-50/50 border border-emerald-200/80 p-5 rounded-2xl space-y-2">
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                                    {{ $resp->user ? $resp->user->name : 'Administrator' }}
                                </span>
                                <span>{{ $resp->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $resp->response }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-100 mt-4">
                    <i data-lucide="clock" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                    <p class="text-xs text-slate-500">Belum ada tanggapan resmi dari administrator untuk pengaduan ini.</p>
                </div>
            @endif
        </div>

    </div>
@endsection

