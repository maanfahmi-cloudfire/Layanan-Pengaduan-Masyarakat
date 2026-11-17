<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ComplaintSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $warga;
    protected User $wargaLain;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Setup Admin
        $this->admin = User::create([
            'name' => 'Admin Gayo Lues',
            'email' => 'admin@test.com',
            'phone' => '081234567890',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Kampung Jawa',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 2. Setup Warga 1
        $this->warga = User::create([
            'name' => 'Warga Blangkejeren',
            'email' => 'warga@test.com',
            'phone' => '085211223344',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Bustanusalam',
            'password' => bcrypt('password123'),
            'role' => 'masyarakat',
        ]);

        // 3. Setup Warga 2
        $this->wargaLain = User::create([
            'name' => 'Warga Kutapanjang',
            'email' => 'wargalain@test.com',
            'phone' => '082199887766',
            'kecamatan' => 'Kutapanjang',
            'desa' => 'Rikit Dekat',
            'password' => bcrypt('password123'),
            'role' => 'masyarakat',
        ]);

        // 4. Setup Kategori
        $this->category = Category::create([
            'name' => 'Infrastruktur dan Jalan',
            'slug' => 'infrastruktur-dan-jalan',
            'description' => 'Kerusakan jalan dan jembatan',
            'icon' => 'truck',
            'is_active' => true,
        ]);
    }

    /**
     * Test Halaman Publik dapat diakses bebas tanpa login
     */
    public function test_public_pages_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/tentang')->assertStatus(200);
        $this->get('/panduan')->assertStatus(200);
        $this->get('/lacak')->assertStatus(200);
    }

    /**
     * Test Registrasi Masyarakat dengan data lengkap Gayo Lues
     */
    public function test_masyarakat_registration_success(): void
    {
        $response = $this->post('/register', [
            'name' => 'Tengku Ali',
            'email' => 'ali@gayolues.id',
            'phone' => '081377889900',
            'kecamatan' => 'Terangun',
            'desa' => 'Padang',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'ali@gayolues.id',
            'role' => 'masyarakat',
            'kecamatan' => 'Terangun',
        ]);
    }

    /**
     * Test Pembuatan Pengaduan Baru dan Generate Nomor Tiket Otomatis
     */
    public function test_create_complaint_and_generate_ticket(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('bukti_jalan.jpg');

        $response = $this->actingAs($this->warga)->post('/pengaduan', [
            'title' => 'Jembatan Gantung Rusak Berat di Bustanusalam',
            'category_id' => $this->category->id,
            'description' => 'Lantai papan jembatan gantung banyak yang patah membahayakan anak sekolah saat melintas setiap pagi.',
            'location' => 'Jembatan Arakundo Dusun II',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Bustanusalam',
            'incident_date' => now()->toDateString(),
            'photo' => $photo,
        ]);

        $this->assertDatabaseHas('complaints', [
            'title' => 'Jembatan Gantung Rusak Berat di Bustanusalam',
            'user_id' => $this->warga->id,
            'status' => 'menunggu_verifikasi',
        ]);

        $complaint = Complaint::where('title', 'Jembatan Gantung Rusak Berat di Bustanusalam')->first();
        $this->assertNotNull($complaint);
        $this->assertStringStartsWith('GL-', $complaint->ticket_number);

        // Verifikasi file tersimpan
        $this->assertNotNull($complaint->photo_path);
        Storage::disk('public')->assertExists($complaint->photo_path);

        // Cek riwayat status awal
        $this->assertDatabaseHas('complaint_status_histories', [
            'complaint_id' => $complaint->id,
            'new_status' => 'menunggu_verifikasi',
        ]);
    }

    /**
     * Test Hak Akses: Warga tidak boleh melihat detail pengaduan warga lain
     */
    public function test_masyarakat_cannot_view_others_complaint(): void
    {
        $complaint = Complaint::create([
            'ticket_number' => 'GL-2026-000001',
            'user_id' => $this->warga->id,
            'category_id' => $this->category->id,
            'title' => 'Laporan Rahasia Warga 1',
            'description' => 'Deskripsi rahasia yang tidak boleh dilihat warga lain',
            'location' => 'Blangkejeren',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Bustanusalam',
            'incident_date' => now()->toDateString(),
            'status' => 'menunggu_verifikasi',
        ]);

        // Warga 2 mencoba membuka detail pengaduan milik Warga 1
        $response = $this->actingAs($this->wargaLain)->get("/pengaduan/{$complaint->id}");
        $response->assertRedirect(route('complaints.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test Admin: Verifikasi Pengaduan
     */
    public function test_admin_can_verify_complaint(): void
    {
        $complaint = Complaint::create([
            'ticket_number' => 'GL-2026-000002',
            'user_id' => $this->warga->id,
            'category_id' => $this->category->id,
            'title' => 'Saluran Irigasi Tersumbat',
            'description' => 'Aliran air tersumbat lumpur pasca hujan deras semalam.',
            'location' => 'Persawahan Bustanusalam',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Bustanusalam',
            'incident_date' => now()->toDateString(),
            'status' => 'menunggu_verifikasi',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/pengaduan/{$complaint->id}/verifikasi", [
            'note' => 'Berkas laporan valid dan telah diverifikasi.',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('diverifikasi', $complaint->fresh()->status);
        $this->assertDatabaseHas('complaint_status_histories', [
            'complaint_id' => $complaint->id,
            'new_status' => 'diverifikasi',
        ]);
    }

    /**
     * Test Admin: Tolak Pengaduan dengan Alasan Wajib
     */
    public function test_admin_can_reject_complaint_with_reason(): void
    {
        $complaint = Complaint::create([
            'ticket_number' => 'GL-2026-000003',
            'user_id' => $this->warga->id,
            'category_id' => $this->category->id,
            'title' => 'Sengketa Batas Tanah Warisan',
            'description' => 'Ada perselisihan batas tanah halaman rumah antar sepupu.',
            'location' => 'Kampung Jawa',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Kampung Jawa',
            'incident_date' => now()->toDateString(),
            'status' => 'menunggu_verifikasi',
        ]);

        $reason = 'Pengaduan ditolak karena urusan sengketa perdata warisan keluarga di luar wewenang pemerintah.';
        $response = $this->actingAs($this->admin)->post("/admin/pengaduan/{$complaint->id}/tolak", [
            'rejection_reason' => $reason,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('ditolak', $complaint->fresh()->status);
        $this->assertEquals($reason, $complaint->fresh()->rejection_reason);
    }

    /**
     * Test Admin: Tambah Tanggapan Resmi
     */
    public function test_admin_can_add_response(): void
    {
        $complaint = Complaint::create([
            'ticket_number' => 'GL-2026-000004',
            'user_id' => $this->warga->id,
            'category_id' => $this->category->id,
            'title' => 'Lampu PJU Padam di Simpang Empat',
            'description' => 'Lampu jalan mati sejak kemarin lusa.',
            'location' => 'Simpang Empat Blangkejeren',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Bustanusalam',
            'incident_date' => now()->toDateString(),
            'status' => 'diverifikasi',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/pengaduan/{$complaint->id}/tanggapan", [
            'response' => 'Tim teknisi dinas perhubungan telah mengganti bohlam lampu PJU yang terbakar.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('complaint_responses', [
            'complaint_id' => $complaint->id,
            'user_id' => $this->admin->id,
        ]);
    }

    /**
     * Test Pelacakan Publik Menggunakan Nomor Tiket
     */
    public function test_public_track_complaint(): void
    {
        $complaint = Complaint::create([
            'ticket_number' => 'GL-2026-000005',
            'user_id' => $this->warga->id,
            'category_id' => $this->category->id,
            'title' => 'Pohon Tumbang di Pinggir Jalan',
            'description' => 'Dahan pohon tumbang menutupi bahu jalan.',
            'location' => 'Km 5 Rikit Gaib',
            'kecamatan' => 'Rikit Gaib',
            'desa' => 'Pinang Jerango',
            'incident_date' => now()->toDateString(),
            'status' => 'diverifikasi',
        ]);

        $response = $this->get("/lacak?ticket={$complaint->ticket_number}");
        $response->assertStatus(200);
        $response->assertSee('GL-2026-000005');
        $response->assertSee('Pohon Tumbang di Pinggir Jalan');
        // Pastikan nomor HP pelapor tidak bocor di publik
        $response->assertDontSee($this->warga->phone);
    }
}

