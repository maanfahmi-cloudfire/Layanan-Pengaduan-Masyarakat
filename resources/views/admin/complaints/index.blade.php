@extends('layouts.admin')

@section('title', 'Manajemen Pengaduan')
@section('page_title', 'Kelola Seluruh Pengaduan')

@section('content')
    <!-- Filter & Toolbar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm mb-6">
        <form action="{{ route('admin.complaints.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            
            <!-- Pencarian -->
            <div class="relative lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor tiket, judul, atau pelapor..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
            </div>

            <!-- Kategori -->
            <div>
                <select name="category_id" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
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
                <select name="kecamatan" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatanList as $kec)
                        <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>
                            Kec. {{ $kec }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    <option value="">Semua Status</option>
                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="sedang_diproses" {{ request('status') == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                @if(request()->hasAny(['search', 'category_id', 'kecamatan', 'status']))
                    <a href="{{ route('admin.complaints.index') }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors shrink-0" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        @if($complaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-4 px-6">Tiket & Tanggal</th>
                            <th class="py-4 px-6">Pelapor</th>
                            <th class="py-4 px-6">Judul Pengaduan</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Kecamatan</th>
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
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="font-bold text-slate-900">{{ $c->user ? $c->user->name : '-' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $c->user ? $c->user->phone : '-' }}</div>
                                </td>
                                <td class="py-4 px-6 max-w-xs">
                                    <div class="font-bold text-slate-900 leading-snug truncate">{{ $c->title }}</div>
                                    <div class="text-[11px] text-slate-400 truncate mt-0.5">{{ $c->location }} ({{ $c->desa }})</div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-medium">
                                        <i data-lucide="{{ $c->category->icon ?: 'folder' }}" class="w-3.5 h-3.5 text-brand-600"></i>
                                        {{ $c->category->name }}
                                    </span>
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
                                    <a href="{{ route('admin.complaints.show', $c->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-900 hover:bg-brand-800 text-white font-bold rounded-lg transition-colors">
                                        <span>Kelola</span>
                                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
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
                    <i data-lucide="inbox" class="w-8 h-8"></i>
                </div>
                <h4 class="text-base font-bold text-slate-800">Tidak Ada Data Pengaduan</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Tidak ditemukan pengaduan yang cocok dengan kriteria pencarian atau filter yang dipilih.
                </p>
                <div class="pt-2">
                    <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

