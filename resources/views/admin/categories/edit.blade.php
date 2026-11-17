@extends('layouts.admin')

@section('title', 'Edit Kategori: ' . $category->name)
@section('page_title', 'Perbarui Kategori Pengaduan')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Kategori
        </a>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Kategori -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ikon Lucide -->
                <div>
                    <label for="icon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Ikon Lucide
                    </label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 font-mono">
                </div>

                <!-- Deskripsi Kategori -->
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Deskripsi Penjelasan Kategori
                    </label>
                    <textarea id="description" name="description" rows="3" class="w-full p-4 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 leading-relaxed">{{ old('description', $category->description) }}</textarea>
                </div>

                <!-- Status Aktif Checkbox -->
                <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                    <label for="is_active" class="text-xs font-semibold text-slate-700 cursor-pointer">
                        Status Kategori Aktif (Dapat dipilih oleh masyarakat pada formulir pengaduan).
                    </label>
                </div>

                <!-- Catatan Relasi -->
                @if($category->complaints_count > 0)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-800 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-blue-600 shrink-0"></i>
                        <span>Kategori ini saat ini sedang terhubung dengan <strong>{{ $category->complaints_count }}</strong> laporan pengaduan masyarakat.</span>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl shadow transition-colors flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection

