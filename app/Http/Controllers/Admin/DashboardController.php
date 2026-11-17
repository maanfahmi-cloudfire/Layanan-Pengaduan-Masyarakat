<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Kartu statistik utama
        $stats = [
            'total' => Complaint::count(),
            'total_users' => User::where('role', 'masyarakat')->count(),
            'menunggu' => Complaint::where('status', Complaint::STATUS_MENUNGGU)->count(),
            'diverifikasi' => Complaint::where('status', Complaint::STATUS_DIVERIFIKASI)->count(),
            'diproses' => Complaint::where('status', Complaint::STATUS_DIPROSES)->count(),
            'selesai' => Complaint::where('status', Complaint::STATUS_SELESAI)->count(),
            'ditolak' => Complaint::where('status', Complaint::STATUS_DITOLAK)->count(),
        ];

        // 1. Data Grafik berdasarkan Kategori
        $categoriesData = Category::withCount('complaints')
            ->has('complaints')
            ->get();
        $categoryLabels = $categoriesData->pluck('name');
        $categoryCounts = $categoriesData->pluck('complaints_count');

        // 2. Data Grafik berdasarkan Kecamatan di Gayo Lues
        $kecamatanStats = Complaint::select('kecamatan', DB::raw('count(*) as total'))
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->get();
        $kecamatanLabels = $kecamatanStats->pluck('kecamatan');
        $kecamatanCounts = $kecamatanStats->pluck('total');

        // 3. Data Grafik berdasarkan Waktu (Bulan di tahun berjalan)
        $monthlyStats = Complaint::select(
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw('count(*) as total')
            )
            ->where(DB::raw("strftime('%Y', created_at)"), date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Siapkan 12 bulan
        $monthsName = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $key = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $monthlyData[] = $monthlyStats[$key] ?? 0;
        }

        // 6 Pengaduan terbaru untuk dipantau admin
        $recentComplaints = Complaint::with(['user', 'category'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'categoryLabels',
            'categoryCounts',
            'kecamatanLabels',
            'kecamatanCounts',
            'monthsName',
            'monthlyData',
            'recentComplaints'
        ));
    }
}

