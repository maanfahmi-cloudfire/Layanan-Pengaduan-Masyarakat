<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Masyarakat') - Layanan Pengaduan Gayo Lues</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Lucide Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            500: '#0284c7',
                            600: '#0369a1',
                            800: '#0f3a63',
                            900: '#0a2540',
                        },
                        accent: {
                            500: '#10b981',
                            600: '#059669',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Top Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white border-b border-slate-200" x-data="{ mobileMenuOpen: false, userDropdown: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Left: Brand Logo -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-900 flex items-center justify-center text-white shadow-sm">
                            <i data-lucide="megaphone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold tracking-widest uppercase text-brand-600">Pengaduan Masyarakat</div>
                            <div class="text-base font-extrabold text-brand-900 leading-tight">Gayo Lues</div>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    <div class="hidden md:flex items-center gap-1 border-l border-slate-200 pl-6 text-sm font-semibold text-slate-600">
                        <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('complaints.index') }}" class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('complaints.index') || request()->routeIs('complaints.show') ? 'bg-brand-50 text-brand-600 font-bold' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                            Riwayat Pengaduan
                        </a>
                        <a href="{{ route('track') }}" target="_blank" class="px-3.5 py-2 rounded-xl transition-colors hover:bg-slate-50 hover:text-slate-900 flex items-center gap-1.5">
                            <span>Lacak Publik</span>
                            <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Right: Action CTA & User Dropdown -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:scale-105">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        Buat Pengaduan
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-3 p-1.5 pr-3 rounded-full hover:bg-slate-100 transition-colors focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-800 font-bold text-xs flex items-center justify-center">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="text-left text-xs">
                                <div class="font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</div>
                                <div class="text-[10px] text-slate-400">Kec. {{ auth()->user()->kecamatan }}</div>
                            </div>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                        </button>

                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-lg border border-slate-200 py-1.5 text-xs text-slate-700">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <div class="font-bold text-slate-900 truncate">{{ auth()->user()->name }}</div>
                                <div class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 transition-colors">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                                Pengaturan Akun
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-rose-600 hover:bg-rose-50 transition-colors">
                                    <i data-lucide="log-out" class="w-4 h-4 text-rose-500"></i>
                                    Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-b border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">Dashboard</a>
            <a href="{{ route('complaints.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('complaints.index') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">Riwayat Pengaduan</a>
            <a href="{{ route('complaints.create') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-emerald-700 bg-emerald-50">Buat Pengaduan Baru</a>
            <a href="{{ route('track') }}" target="_blank" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Lacak Pengaduan Publik</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Pengaturan Akun</a>
            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-100">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 rounded-lg">Keluar (Logout)</button>
            </form>
        </div>
    </nav>

    <!-- Flash Messages Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 mb-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl" role="alert">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                <div class="text-xs sm:text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 p-4 mb-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl" role="alert">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                <div class="text-xs sm:text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Layanan Pengaduan Masyarakat Gayo Lues • Platform Partisipasi Warga</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>

