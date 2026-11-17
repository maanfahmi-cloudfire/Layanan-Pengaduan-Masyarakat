<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Masyarakat</h2>
        <p class="text-xs text-slate-500 mt-1">Lengkapi data diri Anda untuk mulai menyampaikan pengaduan</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap</label>
            <div class="relative">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Contoh: Aman Mayak">
                <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
            </div>
            @error('name')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email & No HP (2 Kolom) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="nama@email.com">
                    <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
                </div>
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">No. HP / WhatsApp</label>
                <div class="relative">
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="081234567890">
                    <i data-lucide="phone" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
                </div>
                @error('phone')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Wilayah Gayo Lues: Kecamatan & Desa (2 Kolom) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="kecamatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kecamatan</label>
                <div class="relative">
                    <select id="kecamatan" name="kecamatan" required class="w-full pl-10 pr-8 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all appearance-none">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec }}" {{ old('kecamatan') == $kec ? 'selected' : '' }}>
                                Kec. {{ $kec }}
                            </option>
                        @endforeach
                    </select>
                    <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none"></i>
                </div>
                @error('kecamatan')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="desa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Desa / Kampung</label>
                <div class="relative">
                    <input id="desa" type="text" name="desa" value="{{ old('desa') }}" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Contoh: Bustanusalam">
                    <i data-lucide="home" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
                </div>
                @error('desa')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Password & Konfirmasi Password (2 Kolom) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="••••••••">
                    <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
                </div>
                @error('password')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Ulangi Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="••••••••">
                    <i data-lucide="check" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-3">
            <button type="submit" class="w-full py-3 px-4 bg-brand-900 hover:bg-brand-800 text-white text-sm font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Daftar Sekarang
            </button>
        </div>
    </form>

    <!-- Login Link -->
    <div class="mt-6 text-center text-xs text-slate-600 pt-4 border-t border-slate-100">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-800 hover:underline">
            Masuk ke Akun
        </a>
    </div>
</x-guest-layout>
