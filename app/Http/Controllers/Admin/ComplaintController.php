<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Masyarakat\ComplaintController as UserComplaintController;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintResponse;
use App\Models\ComplaintStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    /**
     * Tampilkan seluruh daftar pengaduan dengan filter lengkap
     */
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'category']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Filter nomor tiket, judul, atau nama pelapor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $complaints = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $kecamatanList = UserComplaintController::getKecamatanList();

        return view('admin.complaints.index', compact('complaints', 'categories', 'kecamatanList'));
    }

    /**
     * Tampilkan detail pengaduan
     */
    public function show($id)
    {
        $complaint = Complaint::with(['user', 'category', 'responses.user', 'statusHistories.changer'])
            ->findOrFail($id);

        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Verifikasi pengaduan
     */
    public function verify(Request $request, $id)
    {
        $admin = $request->user();
        $complaint = Complaint::findOrFail($id);

        if ($complaint->status !== Complaint::STATUS_MENUNGGU) {
            return back()->with('error', 'Hanya pengaduan berstatus Menunggu Verifikasi yang dapat diverifikasi.');
        }

        DB::transaction(function () use ($complaint, $admin, $request) {
            $oldStatus = $complaint->status;
            $complaint->update([
                'status' => Complaint::STATUS_DIVERIFIKASI,
                'rejection_reason' => null,
            ]);

            ComplaintStatusHistory::create([
                'complaint_id' => $complaint->id,
                'changed_by' => $admin->id,
                'old_status' => $oldStatus,
                'new_status' => Complaint::STATUS_DIVERIFIKASI,
                'note' => $request->input('note', 'Pengaduan telah diverifikasi oleh Administrator dan dinyatakan valid.'),
            ]);
        });

        return back()->with('success', "Pengaduan {$complaint->ticket_number} berhasil diverifikasi.");
    }

    /**
     * Tolak pengaduan beserta alasan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan pengaduan wajib dicantumkan.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter agar jelas bagi pelapor.',
        ]);

        $admin = $request->user();
        $complaint = Complaint::findOrFail($id);

        DB::transaction(function () use ($complaint, $admin, $request) {
            $oldStatus = $complaint->status;
            $complaint->update([
                'status' => Complaint::STATUS_DITOLAK,
                'rejection_reason' => $request->rejection_reason,
            ]);

            ComplaintStatusHistory::create([
                'complaint_id' => $complaint->id,
                'changed_by' => $admin->id,
                'old_status' => $oldStatus,
                'new_status' => Complaint::STATUS_DITOLAK,
                'note' => 'Pengaduan ditolak: ' . $request->rejection_reason,
            ]);
        });

        return back()->with('success', "Pengaduan {$complaint->ticket_number} telah ditolak dengan alasan yang tercatat.");
    }

    /**
     * Perbarui status pengaduan (sedang_diproses / selesai)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:diverifikasi,sedang_diproses,selesai'],
            'note' => ['nullable', 'string', 'max:500'],
        ], [
            'status.required' => 'Status baru wajib dipilih.',
            'status.in' => 'Pilihan status tidak valid.',
        ]);

        $admin = $request->user();
        $complaint = Complaint::findOrFail($id);

        DB::transaction(function () use ($complaint, $admin, $request) {
            $oldStatus = $complaint->status;
            $complaint->update([
                'status' => $request->status,
            ]);

            ComplaintStatusHistory::create([
                'complaint_id' => $complaint->id,
                'changed_by' => $admin->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'note' => $request->note ?: 'Status diperbarui menjadi ' . $complaint->status_label,
            ]);
        });

        return back()->with('success', "Status pengaduan {$complaint->ticket_number} berhasil diperbarui menjadi {$complaint->status_label}.");
    }

    /**
     * Tambahkan tanggapan resmi admin
     */
    public function addResponse(Request $request, $id)
    {
        $request->validate([
            'response' => ['required', 'string', 'min:5', 'max:2000'],
        ], [
            'response.required' => 'Teks tanggapan wajib diisi.',
            'response.min' => 'Teks tanggapan minimal 5 karakter.',
        ]);

        $admin = $request->user();
        $complaint = Complaint::findOrFail($id);

        ComplaintResponse::create([
            'complaint_id' => $complaint->id,
            'user_id' => $admin->id,
            'response' => $request->response,
        ]);

        return back()->with('success', 'Tanggapan resmi berhasil ditambahkan.');
    }
}

