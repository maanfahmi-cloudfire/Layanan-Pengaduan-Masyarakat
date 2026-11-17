<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk ke Akun Anda</h2>
        <p class="text-xs text-slate-500 mt-1">Silakan masukkan email dan password untuk melanjutkan</p>
    </div>

    <!-- Alert Notifikasi Session -->
    @if (session('status'))
        <div class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 p-3 rounded-xl flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if (session('info'))
        <div class="mb-4 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 p-3 rounded-xl flex items-center gap-2">
            <i data-lucide="info" class="w-4 h-4 text-blue-600 shrink-0"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 p-3 rounded-xl flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Email</label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="nama@email.com">
                <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
            </div>
            @error('email')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password</label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="••••••••">
                <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 pointer-events-none"></i>
            </div>
            @error('password')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500" name="remember">
                <span class="ml-2 text-xs text-slate-600 font-medium">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-brand-900 hover:bg-brand-800 text-white text-sm font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                Masuk Sekarang
            </button>
        </div>
    </form>

    <!-- Quick Demo Account Switcher (Untuk Kemudahan Pengujian UAS) -->
    <div class="mt-6 pt-6 border-t border-slate-100 bg-slate-50 -mx-6 -mb-6 sm:-mx-10 sm:-mb-10 p-6 rounded-b-3xl">
        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2 text-center">Klik Tombol di Bawah Untuk Isi Akun Otomatis:</span>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <button type="button" onclick="fillAccount('admin@gayolues.go.id', 'password123')" class="p-2.5 bg-white border border-slate-200 hover:border-brand-500 rounded-xl text-left transition-colors group shadow-xs">
                <span class="font-bold text-brand-900 block group-hover:text-brand-600 flex items-center gap-1">
                    <i data-lucide="shield" class="w-3.5 h-3.5 text-brand-600"></i>
                    Admin Utama
                </span>
                <span class="text-[11px] text-slate-400 block truncate mt-0.5">admin@gayolues.go.id</span>
            </button>
            <button type="button" onclick="fillAccount('warga1@gayolues.id', 'password123')" class="p-2.5 bg-white border border-slate-200 hover:border-accent-500 rounded-xl text-left transition-colors group shadow-xs">
                <span class="font-bold text-slate-800 block group-hover:text-accent-600 flex items-center gap-1">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-emerald-600"></i>
                    Masyarakat (Warga)
                </span>
                <span class="text-[11px] text-slate-400 block truncate mt-0.5">warga1@gayolues.id</span>
            </button>
        </div>
        <p class="text-[10px] text-slate-400 text-center mt-2.5">Password default akun: <code>password123</code></p>
    </div>

    <!-- Register Link -->
    <div class="mt-6 text-center text-xs text-slate-600">
        Belum memiliki akun masyarakat?
        <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-800 hover:underline">
            Daftar Akun Baru
        </a>
    </div>

    <script>
        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
