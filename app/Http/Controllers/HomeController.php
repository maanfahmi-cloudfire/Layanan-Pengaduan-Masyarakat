<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Homepage
     */
    public function index()
    {
        // Statistik publik
        $stats = [
            'total' => Complaint::count(),
            'menunggu' => Complaint::where('status', Complaint::STATUS_MENUNGGU)->count(),
            'diproses' => Complaint::whereIn('status', [Complaint::STATUS_DIVERIFIKASI, Complaint::STATUS_DIPROSES])->count(),
            'selesai' => Complaint::where('status', Complaint::STATUS_SELESAI)->count(),
        ];

        // Kategori aktif beserta jumlah laporannya
        $categories = Category::where('is_active', true)
            ->withCount('complaints')
            ->get();

        // Pengaduan terbaru publik (disensor nama pelapor demi privasi)
        $recentComplaints = Complaint::with('category')
            ->where('status', '!=', Complaint::STATUS_MENUNGGU)
            ->latest()
            ->take(6)
            ->get();

        return view('public.home', compact('stats', 'categories', 'recentComplaints'));
    }

    /**
     * Halaman Tentang
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Halaman Panduan
     */
    public function guide()
    {
        return view('public.guide');
    }

    /**
     * Halaman Lacak Pengaduan
     */
    public function track(Request $request)
    {
        $complaint = null;
        $ticket = trim($request->input('ticket', ''));

        if (! empty($ticket)) {
            $complaint = Complaint::with(['category', 'responses', 'statusHistories'])
                ->where('ticket_number', strtoupper($ticket))
                ->first();
        }

        return view('public.track', compact('complaint', 'ticket'));
    }
}

