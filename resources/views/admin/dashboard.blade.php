@extends('layouts.admin')

@section('title', 'Dashboard Administrator')
@section('page_title', 'Statistik & Dashboard Pengaduan')

@section('content')
    <!-- 7 Kartu Statistik Utama -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-4 mb-8">
        
        <!-- Total Pengaduan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm col-span-2 sm:col-span-1">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Pengaduan</span>
            <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['total']) }}</div>
            <span class="text-[11px] text-brand-600 font-semibold mt-1 block">Seluruh Laporan</span>
        </div>

        <!-- Masyarakat Terdaftar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Warga Terdaftar</span>
            <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['total_users']) }}</div>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Akun Masyarakat</span>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm">
            <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block">Menunggu Verifikasi</span>
            <div class="text-3xl font-extrabold text-amber-900 mt-1">{{ number_format($stats['menunggu']) }}</div>
            <span class="text-[11px] text-amber-600 font-semibold mt-1 block">Perlu Ditinjau</span>
        </div>

        <!-- Diverifikasi -->
        <div class="bg-white p-5 rounded-2xl border border-sky-200 shadow-sm">
            <span class="text-[11px] font-bold text-sky-700 uppercase tracking-wider block">Diverifikasi</span>
            <div class="text-3xl font-extrabold text-sky-900 mt-1">{{ number_format($stats['diverifikasi']) }}</div>
            <span class="text-[11px] text-sky-600 font-semibold mt-1 block">Lolos Verifikasi</span>
        </div>

        <!-- Sedang Diproses -->
        <div class="bg-white p-5 rounded-2xl border border-blue-200 shadow-sm">
            <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider block">Sedang Diproses</span>
            <div class="text-3xl font-extrabold text-blue-900 mt-1">{{ number_format($stats['diproses']) }}</div>
            <span class="text-[11px] text-blue-600 font-semibold mt-1 block">Tindakan Lapangan</span>
        </div>

        <!-- Selesai -->
        <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm">
            <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block">Selesai</span>
            <div class="text-3xl font-extrabold text-emerald-900 mt-1">{{ number_format($stats['selesai']) }}</div>
            <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Tuntas Ditangani</span>
        </div>

        <!-- Ditolak -->
        <div class="bg-white p-5 rounded-2xl border border-rose-200 shadow-sm">
            <span class="text-[11px] font-bold text-rose-700 uppercase tracking-wider block">Ditolak</span>
            <div class="text-3xl font-extrabold text-rose-900 mt-1">{{ number_format($stats['ditolak']) }}</div>
            <span class="text-[11px] text-rose-600 font-semibold mt-1 block">Tidak Memenuhi Syarat</span>
        </div>

    </div>

    <!-- 3 Grafik Interaktif Chart.js -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Grafik 1: Kategori Pengaduan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Pengaduan Berdasarkan Kategori</h3>
                    <i data-lucide="pie-chart" class="w-4 h-4 text-brand-600"></i>
                </div>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 text-center mt-4 border-t border-slate-100 pt-3">
                Distribusi bidang permasalahan yang dilaporkan warga.
            </p>
        </div>

        <!-- Grafik 2: Tren Bulanan (Waktu) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm lg:col-span-2 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Tren Pengaduan per Bulan (Tahun {{ date('Y') }})</h3>
                    <i data-lucide="line-chart" class="w-4 h-4 text-brand-600"></i>
                </div>
                <div class="h-64 relative">
                    <canvas id="timeChart"></canvas>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 text-center mt-4 border-t border-slate-100 pt-3">
                Frekuensi volume laporan yang masuk setiap bulan sepanjang tahun berjalan.
            </p>
        </div>

    </div>

    <!-- Grafik 3: Berdasarkan Kecamatan di Gayo Lues -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Sebaran Pengaduan Berdasarkan Kecamatan</h3>
                <p class="text-xs text-slate-400">Pemetaan konsentrasi keluhan masyarakat pada 11 kecamatan di Kabupaten Gayo Lues.</p>
            </div>
            <i data-lucide="bar-chart-3" class="w-5 h-5 text-brand-600"></i>
        </div>
        <div class="h-64 relative">
            <canvas id="kecamatanChart"></canvas>
        </div>
    </div>

    <!-- Tabel Pengaduan Terbaru Yang Masuk -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Laporan Pengaduan Terbaru Masuk</h3>
                <p class="text-xs text-slate-400 mt-0.5">Pantau dan verifikasi laporan secara berkala.</p>
            </div>
            <a href="{{ route('admin.complaints.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-800 flex items-center gap-1">
                <span>Buka Seluruh Pengaduan</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 uppercase tracking-wider font-bold">
                        <th class="py-4 px-6">Tiket & Tanggal</th>
                        <th class="py-4 px-6">Pelapor</th>
                        <th class="py-4 px-6">Judul Laporan</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Wilayah</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentComplaints as $c)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-mono font-bold text-slate-900">{{ $c->ticket_number }}</div>
                                <div class="text-[11px] text-slate-400">{{ $c->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-bold text-slate-800">{{ $c->user ? $c->user->name : '-' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $c->user ? $c->user->phone : '-' }}</div>
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                <div class="font-bold text-slate-900 leading-snug truncate">{{ $c->title }}</div>
                                <div class="text-[11px] text-slate-400 truncate">{{ $c->location }}</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap font-medium text-slate-800">
                                {{ $c->category ? $c->category->name : '-' }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="font-medium text-slate-800">Kec. {{ $c->kecamatan }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $c->desa }}</span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full border {{ $c->status_badge_class }}">
                                    {{ $c->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-right">
                                <a href="{{ route('admin.complaints.show', $c->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-brand-900 hover:bg-brand-800 text-white font-bold rounded-lg transition-colors">
                                    <span>Tinjau</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">
                                Belum ada data pengaduan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // 1. Chart Kategori
    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCategory, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryCounts) !!},
                backgroundColor: [
                    '#0284c7', '#10b981', '#f59e0b', '#ef4444', 
                    '#8b5cf6', '#06b6d4', '#ec4899', '#64748b'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, font: { size: 10 } }
                }
            }
        }
    });

    // 2. Chart Waktu (Tren Bulanan)
    const ctxTime = document.getElementById('timeChart').getContext('2d');
    new Chart(ctxTime, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthsName) !!},
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: {!! json_encode($monthlyData) !!},
                borderColor: '#0f3a63',
                backgroundColor: 'rgba(15, 58, 99, 0.08)',
                fill: true,
                tension: 0.35,
                borderWidth: 2.5,
                pointBackgroundColor: '#0284c7',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 10 } },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { font: { size: 10 } },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 3. Chart Kecamatan
    const ctxKecamatan = document.getElementById('kecamatanChart').getContext('2d');
    new Chart(ctxKecamatan, {
        type: 'bar',
        data: {
            labels: {!! json_encode($kecamatanLabels) !!},
            datasets: [{
                label: 'Pengaduan Masuk',
                data: {!! json_encode($kecamatanCounts) !!},
                backgroundColor: '#0284c7',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 10 } },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { font: { size: 10 } },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush

