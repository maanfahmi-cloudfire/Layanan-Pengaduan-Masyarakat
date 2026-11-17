<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Daftar 11 Kecamatan di Kabupaten Gayo Lues
     */
    public static function getKecamatanList(): array
    {
        return [
            'Blangkejeren',
            'Kutapanjang',
            'Rikit Gaib',
            'Terangun',
            'Pining',
            'Blangpegayon',
            'Puteri Betung',
            'Dabun Gelang',
            'Blangjerango',
            'Teripe Jaya',
            'Pantan Cuaca',
        ];
    }

    /**
     * Riwayat pengaduan milik masyarakat yang sedang login
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Jika admin membuka /pengaduan, alihkan ke manajemen pengaduan admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.complaints.index');
        }

        $query = Complaint::with('category')
            ->where('user_id', $user->id);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nomor tiket atau judul
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();

        return view('masyarakat.complaints.index', compact('complaints'));
    }

    /**
     * Tampilkan formulir buat pengaduan baru
     */
    public function create(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $kecamatanList = self::getKecamatanList();
        $user = $request->user();

        return view('masyarakat.complaints.create', compact('categories', 'kecamatanList', 'user'));
    }

    /**
     * Simpan pengaduan baru ke database
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:15'],
            'location' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'desa' => ['required', 'string', 'max:100'],
            'incident_date' => ['required', 'date'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // Max 5MB
        ], [
            'title.required' => 'Judul pengaduan wajib diisi.',
            'title.min' => 'Judul pengaduan minimal 5 karakter.',
            'category_id.required' => 'Silakan pilih kategori pengaduan.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'description.required' => 'Deskripsi rincian pengaduan wajib diisi.',
            'description.min' => 'Deskripsi pengaduan minimal 15 karakter agar informasi jelas.',
            'location.required' => 'Lokasi kejadian / alamat spesifik wajib diisi.',
            'kecamatan.required' => 'Silakan pilih kecamatan lokasi kejadian.',
            'desa.required' => 'Nama desa/kampung wajib diisi.',
            'incident_date.required' => 'Tanggal kejadian wajib diisi.',
            'photo.image' => 'File bukti harus berupa gambar.',
            'photo.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran file foto bukti maksimal 5 MB.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = DB::transaction(function () use ($user, $validated, $photoPath) {
            // Generate ticket number with database lock
            $ticketNumber = Complaint::generateTicketNumber();

            $complaint = Complaint::create([
                'ticket_number' => $ticketNumber,
                'user_id' => $user->id,
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'],
                'kecamatan' => $validated['kecamatan'],
                'desa' => $validated['desa'],
                'incident_date' => $validated['incident_date'],
                'photo_path' => $photoPath,
                'status' => Complaint::STATUS_MENUNGGU,
            ]);

            // Catat riwayat status pertama
            ComplaintStatusHistory::create([
                'complaint_id' => $complaint->id,
                'changed_by' => $user->id,
                'old_status' => null,
                'new_status' => Complaint::STATUS_MENUNGGU,
                'note' => 'Pengaduan berhasil diajukan oleh masyarakat.',
            ]);

            return $complaint;
        });

        // Jika dibuat oleh admin saat uji coba
        if ($user->isAdmin()) {
            return redirect()->route('admin.complaints.show', $complaint->id)
                ->with('success', 'Pengaduan berhasil dibuat dan tersimpan!')
                ->with('ticket_number', $complaint->ticket_number);
        }

        return redirect()->route('complaints.show', $complaint->id)
            ->with('success', 'Pengaduan Anda berhasil dikirim!')
            ->with('ticket_number', $complaint->ticket_number);
    }

    /**
     * Detail pengaduan milik masyarakat
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $complaint = Complaint::with(['category', 'responses.user', 'statusHistories.changer'])
            ->findOrFail($id);

        // Jika admin yang membuka, alihkan ke panel detail admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.complaints.show', $complaint->id);
        }

        // Keamanan: Masyarakat hanya boleh melihat pengaduan miliknya sendiri
        if ($complaint->user_id !== $user->id) {
            return redirect()->route('complaints.index')
                ->with('error', 'Akses ditolak. Anda tidak berhak melihat rincian pengaduan milik pengguna lain.');
        }

        return view('masyarakat.complaints.show', compact('complaint'));
    }
}
