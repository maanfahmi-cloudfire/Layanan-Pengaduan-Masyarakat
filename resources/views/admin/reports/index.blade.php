@extends('layouts.admin')

@section('title', 'Laporan & Rekapitulasi')
@section('page_title', 'Rekapitulasi Laporan & Ekspor Data')

@section('content')
    <div class="space-y-6">
        
        <!-- Filter Toolbar Form -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-800 uppercase tracking-wider">
                    <i data-lucide="sliders" class="w-4 h-4 text-brand-600"></i>
                    <span>Filter Periode & Parameter Rekapitulasi</span>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Tombol Cetak PDF / Print -->
                    <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                        <span>Cetak Laporan</span>
                    </a>
                    <!-- Tombol Download Excel -->
                    <a href="{{ route('admin.reports.excel', request()->query()) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                        <i data-lucide="sheet" class="w-3.5 h-3.5"></i>
                        <span>Unduh Excel / CSV</span>
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                
                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Kategori</label>
                    <select name="category_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Kecamatan</label>
                    <select name="kecamatan" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>
                                Kec. {{ $kec }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status & Tombol Terapkan -->
                <div class="flex items-end gap-2">
                    <div class="flex-grow">
                        <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="">Semua Status</option>
                            <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="sedang_diproses" {{ request('status') == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl transition-colors shrink-0">
                        Filter
                    </button>
                </div>

            </form>
        </div>

        <!-- 4 Kotak Ringkasan Hasil Filter -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Terfilter</span>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($summary['total']) }}</div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm">
                <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Selesai Ditangani</span>
                <div class="text-2xl font-extrabold text-emerald-900 mt-1">{{ number_format($summary['selesai']) }}</div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-blue-200 shadow-sm">
                <span class="text-[10px] font-bold text-blue-700 uppercase tracking-wider block">Dalam Proses</span>
                <div class="text-2xl font-extrabold text-blue-900 mt-1">{{ number_format($summary['diproses']) }}</div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-rose-200 shadow-sm">
                <span class="text-[10px] font-bold text-rose-700 uppercase tracking-wider block">Ditolak</span>
                <div class="text-2xl font-extrabold text-rose-900 mt-1">{{ number_format($summary['ditolak']) }}</div>
            </div>
        </div>

        <!-- Tabel Rekap Data -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            @if($complaints->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 uppercase tracking-wider font-bold">
                                <th class="py-4 px-6">No Tiket</th>
                                <th class="py-4 px-6">Tgl Masuk</th>
                                <th class="py-4 px-6">Pelapor</th>
                                <th class="py-4 px-6">Kategori</th>
                                <th class="py-4 px-6">Judul Laporan</th>
                                <th class="py-4 px-6">Kecamatan</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6 text-right">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach($complaints as $c)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-4 px-6 font-mono font-bold text-slate-900 whitespace-nowrap">
                                        {{ $c->ticket_number }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap text-slate-500">
                                        {{ $c->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="font-bold text-slate-900">{{ $c->user ? $c->user->name : '-' }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $c->user ? $c->user->phone : '-' }}</div>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap font-medium text-slate-800">
                                        {{ $c->category ? $c->category->name : '-' }}
                                    </td>
                                    <td class="py-4 px-6 max-w-xs">
                                        <div class="font-bold text-slate-900 truncate leading-snug">{{ $c->title }}</div>
                                        <div class="text-[11px] text-slate-400 truncate">{{ $c->location }}</div>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap font-medium text-slate-800">
                                        Kec. {{ $c->kecamatan }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full border {{ $c->status_badge_class }}">
                                            {{ $c->status_label }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap text-right">
                                        <a href="{{ route('admin.complaints.show', $c->id) }}" class="p-1.5 text-slate-400 hover:text-brand-900 rounded-lg hover:bg-slate-100 transition-colors inline-block">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($complaints->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $complaints->links() }}
                    </div>
                @endif
            @else
                <div class="p-16 text-center text-slate-400 text-xs">
                    Tidak ada laporan pengaduan pada filter parameter yang ditentukan.
                </div>
            @endif
        </div>

    </div>
@endsection

