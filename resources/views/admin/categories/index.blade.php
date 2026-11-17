@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Kelola Kategori Pengaduan')

@section('content')
    <div class="space-y-6">
        
        <!-- Top Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Kategori Permasalahan</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola klasifikasi bidang pengaduan masyarakat di Kabupaten Gayo Lues.</p>
            </div>
            <div>
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:scale-105">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Tambah Kategori Baru
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-4 px-6">Ikon & Nama Kategori</th>
                            <th class="py-4 px-6">Slug Sistem</th>
                            <th class="py-4 px-6">Deskripsi Kategori</th>
                            <th class="py-4 px-6 text-center">Jumlah Pengaduan</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                                            <i data-lucide="{{ $category->icon ?: 'folder' }}" class="w-4 h-4"></i>
                                        </div>
                                        <div class="font-bold text-slate-900">{{ $category->name }}</div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-mono text-[11px] text-slate-400 whitespace-nowrap">
                                    {{ $category->slug }}
                                </td>
                                <td class="py-4 px-6 max-w-sm text-slate-500 text-xs">
                                    {{ $category->description ?: '-' }}
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <span class="inline-block px-3 py-1 font-bold text-xs bg-brand-50 text-brand-700 rounded-full">
                                        {{ $category->complaints_count }} Laporan
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    @if($category->is_active)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 text-slate-500 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors" title="Edit Kategori">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ $category->name }}\'?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Kategori">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    Belum ada kategori pengaduan yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

