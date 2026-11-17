@extends('layouts.masyarakat')

@section('title', 'Buat Pengaduan Baru')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Back Link & Header -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-600 mb-3 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Formulir Pengaduan Masyarakat</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Sampaikan rincian permasalahan atau keluhan pelayanan publik di Gayo Lues dengan lengkap.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ photoName: null, photoPreview: null }">
                @csrf

                <!-- 1. Judul Pengaduan -->
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Judul Pengaduan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Jalan Longsor dan Amblas di Lintas Terangun" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Tuliskan ringkasan inti permasalahan secara singkat dan jelas (5–200 karakter).</p>
                    @error('title')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. Kategori Pengaduan -->
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kategori Permasalahan <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="category_id" name="category_id" required class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all appearance-none">
                            <option value="">-- Pilih Kategori Pengaduan --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-4 top-3.5 pointer-events-none"></i>
                    </div>
                    @error('category_id')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 3. Deskripsi Pengaduan -->
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Rincian Deskripsi Pengaduan <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" placeholder="Jelaskan secara mendalam permasalahan yang terjadi, kronologi, dampak terhadap warga, serta harapan tindak lanjut..." required class="w-full p-4 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all leading-relaxed">{{ old('description') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Minimal 15 karakter agar tim verifikator mendapatkan gambaran situasi yang utuh.</p>
                    @error('description')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 4. Wilayah: Kecamatan & Desa (2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kecamatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kecamatan Lokasi Kejadian <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="kecamatan" name="kecamatan" required class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all appearance-none">
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatanList as $kec)
                                    <option value="{{ $kec }}" {{ (old('kecamatan', $user->kecamatan) == $kec) ? 'selected' : '' }}>
                                        Kec. {{ $kec }}
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-4 top-3.5 pointer-events-none"></i>
                        </div>
                        @error('kecamatan')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="desa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Desa / Kampung <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="desa" name="desa" value="{{ old('desa', $user->desa) }}" placeholder="Contoh: Bustanusalam" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                        @error('desa')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 5. Lokasi Spesifik & Tanggal Kejadian (2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Lokasi Spesifik / Patokan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Depan Puskesmas, 100m dari simpang..." required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                        @error('location')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="incident_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tanggal Kejadian <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="incident_date" name="incident_date" max="{{ date('Y-m-d') }}" value="{{ old('incident_date', date('Y-m-d')) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                        @error('incident_date')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 6. Upload Foto Bukti (Opsional) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Foto Bukti Pendukung (Opsional)
                    </label>
                    <div class="border-2 border-dashed border-slate-300 hover:border-brand-500 rounded-2xl p-6 text-center bg-slate-50 transition-colors cursor-pointer relative">
                        <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/jpg,image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    photoName = file.name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL(file);
                                }
                            ">
                        
                        <div x-show="!photoPreview" class="space-y-2">
                            <div class="w-12 h-12 rounded-2xl bg-white text-slate-400 border border-slate-200 flex items-center justify-center mx-auto shadow-sm">
                                <i data-lucide="image-plus" class="w-6 h-6"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">
                                Klik atau seret foto ke sini untuk mengunggah
                            </div>
                            <p class="text-[11px] text-slate-400">Format yang didukung: JPG, PNG, WEBP (Maksimal 3 MB)</p>
                        </div>

                        <!-- Image Preview -->
                        <div x-show="photoPreview" x-cloak class="space-y-3">
                            <img :src="photoPreview" class="max-h-56 mx-auto rounded-xl shadow-md border border-slate-200 object-cover">
                            <p class="text-xs font-bold text-slate-700" x-text="photoName"></p>
                            <span class="inline-block text-[11px] text-brand-600 underline">Klik untuk mengganti gambar</span>
                        </div>
                    </div>
                    @error('photo')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] text-slate-400 text-center sm:text-left">
                        Pastikan seluruh data yang Anda masukkan akurat dan dapat dipertanggungjawabkan.
                    </p>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-brand-900 hover:bg-brand-800 text-white text-sm font-bold rounded-xl shadow-md shadow-brand-900/10 transition-all hover:scale-105 shrink-0">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        Kirim Pengaduan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

