<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Masyarakat\ComplaintController as UserComplaintController;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Halaman Rekapitulasi dan Filter Laporan
     */
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'category']);

        // Filter Rentang Tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('incident_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('incident_date', '<=', $request->end_date);
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest('incident_date')->paginate(15)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $kecamatanList = UserComplaintController::getKecamatanList();

        // Ringkasan Cepat
        $summary = [
            'total' => (clone $query)->count(),
            'selesai' => (clone $query)->where('status', Complaint::STATUS_SELESAI)->count(),
            'diproses' => (clone $query)->whereIn('status', [Complaint::STATUS_DIVERIFIKASI, Complaint::STATUS_DIPROSES])->count(),
            'ditolak' => (clone $query)->where('status', Complaint::STATUS_DITOLAK)->count(),
        ];

        return view('admin.reports.index', compact('complaints', 'categories', 'kecamatanList', 'summary'));
    }

    /**
     * Cetak / Pratinjau Format PDF Cetak
     */
    public function print(Request $request)
    {
        $query = Complaint::with(['user', 'category']);

        if ($request->filled('start_date')) {
            $query->whereDate('incident_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('incident_date', '<=', $request->end_date);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest('incident_date')->get();
        $filters = $request->only(['start_date', 'end_date', 'category_id', 'kecamatan', 'status']);

        return view('admin.reports.print', compact('complaints', 'filters'));
    }

    /**
     * Ekspor Laporan ke Format Excel / CSV
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $query = Complaint::with(['user', 'category']);

        if ($request->filled('start_date')) {
            $query->whereDate('incident_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('incident_date', '<=', $request->end_date);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest('incident_date')->get();

        $filename = 'Laporan_Pengaduan_Gayo_Lues_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($complaints) {
            $file = fopen('php://output', 'w');

            // Tambahkan BOM untuk support pembacaan aksen UTF-8 pada Microsoft Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header kolom
            fputcsv($file, [
                'No',
                'Nomor Tiket',
                'Tanggal Masuk',
                'Tanggal Kejadian',
                'Nama Pelapor',
                'Nomor HP Pelapor',
                'Kategori',
                'Judul Laporan',
                'Kecamatan',
                'Desa',
                'Lokasi Spesifik',
                'Status Laporan',
                'Alasan Penolakan (Jika Ada)',
            ]);

            $no = 1;
            foreach ($complaints as $c) {
                fputcsv($file, [
                    $no++,
                    $c->ticket_number,
                    $c->created_at->format('d/m/Y H:i'),
                    $c->incident_date->format('d/m/Y'),
                    $c->user ? $c->user->name : '-',
                    $c->user ? $c->user->phone : '-',
                    $c->category ? $c->category->name : '-',
                    $c->title,
                    $c->kecamatan,
                    $c->desa,
                    $c->location,
                    $c->status_label,
                    $c->rejection_reason ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

