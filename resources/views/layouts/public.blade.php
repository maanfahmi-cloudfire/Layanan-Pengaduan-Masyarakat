<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Layanan Pengaduan Masyarakat Gayo Lues')</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via Vite or Tailwind CDN fallback) & Lucide Icons -->
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
                            500: '#0284c7', // Biru muda cerah
                            600: '#0369a1',
                            800: '#0f3a63',
                            900: '#0a2540', // Biru tua elegan
                        },
                        accent: {
                            500: '#10b981', // Aksen hijau
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

    <!-- Header & Navigasi -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-900 via-brand-800 to-brand-600 flex items-center justify-center text-white shadow-md shadow-brand-900/10 group-hover:scale-105 transition-transform">
                        <i data-lucide="megaphone" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold tracking-wider uppercase text-brand-600">Layanan Pengaduan Warga</div>
                        <div class="text-lg font-extrabold text-brand-900 leading-tight">Gayo Lues</div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('home') ? 'text-brand-600 font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('track') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('track') ? 'text-brand-600 font-bold' : '' }}">Lacak Pengaduan</a>
                    <a href="{{ route('guide') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('guide') ? 'text-brand-600 font-bold' : '' }}">Panduan</a>
                    <a href="{{ route('about') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('about') ? 'text-brand-600 font-bold' : '' }}">Tentang</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-brand-900 hover:bg-brand-800 rounded-lg shadow-sm transition-all">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                Panel Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-brand-900 bg-brand-50 hover:bg-brand-100 rounded-lg transition-colors">
                                <i data-lucide="user" class="w-4 h-4"></i>
                                Dashboard Saya
                            </a>
                            <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-accent-500 hover:bg-accent-600 rounded-lg shadow-sm transition-all">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                Buat Pengaduan
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-brand-900 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-brand-900 hover:bg-brand-800 rounded-lg shadow-sm transition-all">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                    <i data-lucide="menu" x-show="!mobileMenuOpen" class="w-6 h-6"></i>
                    <i data-lucide="x" x-show="mobileMenuOpen" x-cloak class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-b border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">Beranda</a>
            <a href="{{ route('track') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('track') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">Lacak Pengaduan</a>
            <a href="{{ route('guide') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('guide') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">Panduan</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">Tentang</a>
            
            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center px-4 py-2.5 text-sm font-semibold text-white bg-brand-900 rounded-lg">Panel Admin</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-2.5 text-sm font-semibold text-brand-900 bg-brand-50 rounded-lg">Dashboard Saya</a>
                        <a href="{{ route('complaints.create') }}" class="w-full text-center px-4 py-2.5 text-sm font-semibold text-white bg-accent-500 rounded-lg">Buat Pengaduan</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 text-sm font-semibold text-slate-700 border border-slate-300 rounded-lg">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center px-4 py-2 text-sm font-semibold text-white bg-brand-900 rounded-lg">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 mb-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl" role="alert">
                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 p-4 mb-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl" role="alert">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if (session('info'))
            <div class="flex items-center gap-3 p-4 mb-4 text-blue-800 bg-blue-50 border border-blue-200 rounded-xl" role="alert">
                <i data-lucide="info" class="w-5 h-5 text-blue-600 shrink-0"></i>
                <div class="text-sm font-medium">{{ session('info') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-900 text-slate-300 pt-16 pb-8 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                
                <!-- Col 1: Profil Layanan -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-600 flex items-center justify-center text-white">
                            <i data-lucide="megaphone" class="w-5 h-5"></i>
                        </div>
                        <span class="text-lg font-extrabold text-white">Pengaduan Warga Gayo Lues</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-md">
                        Sistem informasi pengaduan masyarakat untuk menyalurkan keluhan, aspirasi, dan permasalahan pelayanan publik di Kabupaten Gayo Lues, Provinsi Aceh secara transparan, mudah, dan terukur.
                    </p>
                    <div class="p-3 bg-brand-800/60 border border-brand-700/50 rounded-lg text-xs text-amber-200 flex items-start gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                        <span><strong>Catatan Independen:</strong> Aplikasi ini merupakan proyek akademik UAS & portofolio pengembang, bukan merupakan kanal resmi milik Pemkab Gayo Lues.</span>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Navigasi Layanan</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('track') }}" class="hover:text-white transition-colors">Lacak Pengaduan (Tiket)</a></li>
                        <li><a href="{{ route('guide') }}" class="hover:text-white transition-colors">Panduan Penggunaan</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang Sistem</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk Akun</a></li>
                    </ul>
                </div>

                <!-- Col 3: Cakupan Wilayah Gayo Lues -->
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Wilayah Kecamatan</h4>
                    <p class="text-xs text-slate-400 leading-relaxed mb-3">
                        Meliputi 11 Kecamatan di Kabupaten Gayo Lues:
                    </p>
                    <div class="text-xs text-slate-300 grid grid-cols-2 gap-1">
                        <span>• Blangkejeren</span>
                        <span>• Kutapanjang</span>
                        <span>• Rikit Gaib</span>
                        <span>• Terangun</span>
                        <span>• Pining</span>
                        <span>• Blangpegayon</span>
                        <span>• Puteri Betung</span>
                        <span>• Dabun Gelang</span>
                        <span>• Blangjerango</span>
                        <span>• Teripe Jaya</span>
                        <span>• Pantan Cuaca</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Line -->
            <div class="border-t border-brand-800/80 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} Layanan Pengaduan Masyarakat Gayo Lues. Proyek Aplikasi UAS Web Laravel.</p>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brand-800 text-slate-300">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Sistem Aktif
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>

