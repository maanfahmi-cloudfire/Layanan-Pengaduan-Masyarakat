<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') - Pengaduan Masyarakat Gayo Lues</title>

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
                            900: '#0a2540', // Biru tua formal
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased flex min-h-screen" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-brand-900 text-white flex flex-col transition-transform duration-200 ease-in-out lg:static lg:translate-x-0 shrink-0">
        
        <!-- Sidebar Brand -->
        <div class="h-20 flex items-center px-6 border-b border-brand-800/80 gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand-700 text-white flex items-center justify-center shadow-md">
                <i data-lucide="shield" class="w-5 h-5"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold tracking-widest uppercase text-brand-300">Panel Administrator</div>
                <div class="text-base font-black tracking-tight text-white leading-tight">Gayo Lues</div>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-grow px-4 py-6 space-y-1.5 text-xs font-semibold overflow-y-auto">
            
            <div class="px-3 pb-2 text-[10px] uppercase font-bold text-slate-400 tracking-wider">Menu Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-800 text-white font-bold shadow-sm' : 'text-slate-300 hover:bg-brand-800/50 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-brand-300"></i>
                <span>Dashboard & Statistik</span>
            </a>

            <!-- Kelola Pengaduan -->
            <a href="{{ route('admin.complaints.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.complaints.*') ? 'bg-brand-800 text-white font-bold shadow-sm' : 'text-slate-300 hover:bg-brand-800/50 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i data-lucide="inbox" class="w-4 h-4 text-brand-300"></i>
                    <span>Kelola Pengaduan</span>
                </div>
                @php
                    $pendingCount = \App\Models\Complaint::where('status', \App\Models\Complaint::STATUS_MENUNGGU)->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-400 text-amber-950">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <!-- Kelola Kategori -->
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-brand-800 text-white font-bold shadow-sm' : 'text-slate-300 hover:bg-brand-800/50 hover:text-white' }}">
                <i data-lucide="folder-tree" class="w-4 h-4 text-brand-300"></i>
                <span>Kategori Pengaduan</span>
            </a>

            <!-- Laporan & Ekspor -->
            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-brand-800 text-white font-bold shadow-sm' : 'text-slate-300 hover:bg-brand-800/50 hover:text-white' }}">
                <i data-lucide="file-bar-chart" class="w-4 h-4 text-brand-300"></i>
                <span>Laporan & Rekapitulasi</span>
            </a>

            <div class="px-3 pt-6 pb-2 text-[10px] uppercase font-bold text-slate-400 tracking-wider">Akses Lain</div>

            <!-- Lihat Website Publik -->
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-brand-800/50 hover:text-white transition-all">
                <div class="flex items-center gap-3">
                    <i data-lucide="globe" class="w-4 h-4 text-brand-300"></i>
                    <span>Halaman Publik</span>
                </div>
                <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
            </a>

        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-4 border-t border-brand-800/80 bg-brand-950/40">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-brand-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                    AD
                </div>
                <div class="text-xs truncate">
                    <div class="font-bold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-brand-300">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 text-xs font-semibold text-rose-300 hover:text-white bg-rose-500/10 hover:bg-rose-500/20 rounded-xl transition-colors">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-grow flex flex-col min-w-0 overflow-hidden">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between shrink-0">
            
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 leading-tight">
                        @yield('page_title', 'Dashboard')
                    </h2>
                    <p class="text-xs text-slate-400 hidden sm:block">Sistem Pengelolaan Pengaduan Masyarakat Kabupaten Gayo Lues</p>
                </div>
            </div>

            <!-- Topbar Right Badges -->
            <div class="flex items-center gap-3 text-xs">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 text-slate-600 font-semibold">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-brand-600"></i>
                    <span>{{ date('d F Y') }}</span>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Admin Online
                </span>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 sm:px-8 pt-4 w-full">
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

        <!-- Main Body -->
        <main class="flex-grow p-4 sm:p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>

