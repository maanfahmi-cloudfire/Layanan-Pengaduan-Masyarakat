<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Jika Administrator mengakses URL /dashboard, alihkan ke admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Statistik pengaduan milik user
        $stats = [
            'total' => Complaint::where('user_id', $user->id)->count(),
            'menunggu' => Complaint::where('user_id', $user->id)
                ->where('status', Complaint::STATUS_MENUNGGU)
                ->count(),
            'diproses' => Complaint::where('user_id', $user->id)
                ->whereIn('status', [Complaint::STATUS_DIVERIFIKASI, Complaint::STATUS_DIPROSES])
                ->count(),
            'selesai' => Complaint::where('user_id', $user->id)
                ->where('status', Complaint::STATUS_SELESAI)
                ->count(),
            'ditolak' => Complaint::where('user_id', $user->id)
                ->where('status', Complaint::STATUS_DITOLAK)
                ->count(),
        ];

        // 5 Pengaduan terbaru
        $recentComplaints = Complaint::with('category')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('masyarakat.dashboard', compact('stats', 'recentComplaints'));
    }
}
