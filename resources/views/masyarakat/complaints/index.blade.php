@extends('layouts.masyarakat')

@section('title', 'Riwayat Pengaduan Saya')

@section('content')
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Riwayat Pengaduan Saya</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar seluruh laporan yang pernah Anda sampaikan beserta status terbarunya.</p>
        </div>
        <div>
            <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-accent-500 hover:bg-accent-600 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:scale-105">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Buat Pengaduan Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
        <form action="{{ route('complaints.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            
            <!-- Search by ticket or title -->
            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor tiket atau judul..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-2.5 pointer-events-none"></i>
            </div>

            <!-- Filter Status -->
            <div class="sm:w-56">
                <select name="status" onchange="this.form.submit()" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    <option value="">Semua Status Laporan</option>
                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="sedang_diproses" {{ request('status') == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('complaints.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition-colors flex items-center justify-center gap-1.5 shrink-0">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table or List of Complaints -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        @if($complaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-4 px-6">Tiket & Tanggal</th>
                            <th class="py-4 px-6">Judul Pengaduan</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Lokasi</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($complaints as $c)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="font-mono font-bold text-slate-900">{{ $c->ticket_number }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $c->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="py-4 px-6 max-w-xs">
                                    <div class="font-bold text-slate-900 leading-snug truncate">{{ $c->title }}</div>
                                    <div class="text-[11px] text-slate-400 truncate mt-0.5">{{ $c->description }}</div>
                                    @if($c->status === 'ditolak' && $c->rejection_reason)
                                        <div class="text-[11px] text-rose-600 mt-1 line-clamp-1 italic">
                                            Alasan ditolak: {{ $c->rejection_reason }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-medium">
                                        <i data-lucide="{{ $c->category->icon ?: 'folder' }}" class="w-3.5 h-3.5 text-brand-600"></i>
                                        {{ $c->category->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">Kec. {{ $c->kecamatan }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $c->desa }}</div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border {{ $c->status_badge_class }}">
                                        {{ $c->status_label }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-right">
                                    <a href="{{ route('complaints.show', $c->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold rounded-lg transition-colors">
                                        <span>Detail</span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($complaints->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $complaints->links() }}
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="p-16 text-center space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <i data-lucide="filter-x" class="w-8 h-8"></i>
                </div>
                <h4 class="text-base font-bold text-slate-800">Tidak Ada Laporan yang Ditemukan</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Tidak ditemukan data pengaduan yang sesuai dengan kata kunci atau filter status yang Anda pilih.
                </p>
                <div class="pt-2">
                    <a href="{{ route('complaints.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

