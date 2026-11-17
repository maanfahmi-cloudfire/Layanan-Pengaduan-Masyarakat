<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Layanan Pengaduan Masyarakat Gayo Lues') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
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
</head>
<body class="font-sans text-slate-800 bg-slate-50 antialiased min-h-screen flex flex-col justify-between">

    <div class="py-10 px-4 sm:px-6 lg:px-8 flex-grow flex flex-col items-center justify-center">
        <!-- Logo Branding -->
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-2 group">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-900 to-brand-700 flex items-center justify-center text-white shadow-lg shadow-brand-900/10 group-hover:scale-105 transition-transform">
                    <i data-lucide="megaphone" class="w-7 h-7"></i>
                </div>
                <div class="mt-1">
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block">Layanan Pengaduan</span>
                    <span class="text-xl font-black text-brand-900 block leading-tight">Kabupaten Gayo Lues</span>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-lg bg-white shadow-xl shadow-slate-200/50 border border-slate-200/80 rounded-3xl p-6 sm:p-10">
            {{ $slot }}
        </div>
    </div>

    <!-- Small Footer -->
    <footer class="py-6 text-center text-xs text-slate-400 border-t border-slate-200/60 bg-white">
        &copy; {{ date('Y') }} Pengaduan Warga Gayo Lues. Sistem Informasi Proyek UAS.
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
