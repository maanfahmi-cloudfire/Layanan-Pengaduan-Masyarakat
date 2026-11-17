<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintResponse;
use App\Models\ComplaintStatusHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $warga1 = User::where('email', 'warga1@gayolues.id')->first();
        $warga2 = User::where('email', 'warga2@gayolues.id')->first();

        $catJalan = Category::where('slug', 'infrastruktur-dan-jalan')->first();
        $catAir = Category::where('slug', 'air-bersih')->first();
        $catKesehatan = Category::where('slug', 'kesehatan')->first();
        $catPendidikan = Category::where('slug', 'pendidikan')->first();
        $catLingkungan = Category::where('slug', 'lingkungan-dan-kebersihan')->first();

        // 1. Laporan Selesai
        $complaint1 = Complaint::create([
            'ticket_number' => 'GL-2026-000001',
            'user_id' => $warga1->id,
            'category_id' => $catJalan->id,
            'title' => '[DATA SIMULASI] Jalan Longsor Jalur Blangkejeren - Kutacan',
            'description' => 'Terjadi longsor kecil menutupi setengah badan jalan di dekat Kampung Palok. Membahayakan pengendara yang melintas terutama saat malam hari karena minim penerangan.',
            'location' => 'Jalan Lintas Blangkejeren - Kutacan Km 14',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Palok',
            'incident_date' => Carbon::now()->subDays(10)->toDateString(),
            'photo_path' => null,
            'status' => Complaint::STATUS_SELESAI,
            'created_at' => Carbon::now()->subDays(10),
            'updated_at' => Carbon::now()->subDays(2),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint1->id,
            'changed_by' => $admin->id,
            'old_status' => null,
            'new_status' => Complaint::STATUS_MENUNGGU,
            'note' => 'Pengaduan berhasil didaftarkan ke dalam sistem.',
            'created_at' => Carbon::now()->subDays(10),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint1->id,
            'changed_by' => $admin->id,
            'old_status' => Complaint::STATUS_MENUNGGU,
            'new_status' => Complaint::STATUS_DIVERIFIKASI,
            'note' => 'Laporan telah diverifikasi oleh tim admin dan diteruskan ke Dinas Pekerjaan Umum.',
            'created_at' => Carbon::now()->subDays(9),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint1->id,
            'changed_by' => $admin->id,
            'old_status' => Complaint::STATUS_DIVERIFIKASI,
            'new_status' => Complaint::STATUS_DIPROSES,
            'note' => 'Alat berat loader sedang dikerahkan untuk pembersihan material tanah longsor.',
            'created_at' => Carbon::now()->subDays(6),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint1->id,
            'changed_by' => $admin->id,
            'old_status' => Complaint::STATUS_DIPROSES,
            'new_status' => Complaint::STATUS_SELESAI,
            'note' => 'Pembersihan material longsor telah tuntas dan arus lalu lintas kembali lancar normal.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        ComplaintResponse::create([
            'complaint_id' => $complaint1->id,
            'user_id' => $admin->id,
            'response' => 'Terima kasih atas laporan Anda. Tim UPTD Jalan telah menyelesaikan pembersihan badan jalan pada tanggal ' . Carbon::now()->subDays(2)->format('d F Y') . '. Pengendara kini dapat melintas dengan aman.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        // 2. Laporan Sedang Diproses
        $complaint2 = Complaint::create([
            'ticket_number' => 'GL-2026-000002',
            'user_id' => $warga1->id,
            'category_id' => $catAir->id,
            'title' => '[DATA SIMULASI] Distribusi Air Bersih Terhenti 3 Hari di Bustanusalam',
            'description' => 'Pasokan air bersih PDAM tidak mengalir selama 3 hari berturut-turut di wilayah Dusun Raklunung. Warga kesulitan memenuhi kebutuhan harian.',
            'location' => 'Dusun Raklunung, Kampung Bustanusalam',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Bustanusalam',
            'incident_date' => Carbon::now()->subDays(4)->toDateString(),
            'photo_path' => null,
            'status' => Complaint::STATUS_DIPROSES,
            'created_at' => Carbon::now()->subDays(3),
            'updated_at' => Carbon::now()->subDays(1),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint2->id,
            'changed_by' => $admin->id,
            'old_status' => null,
            'new_status' => Complaint::STATUS_MENUNGGU,
            'note' => 'Laporan masuk dari warga Bustanusalam.',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint2->id,
            'changed_by' => $admin->id,
            'old_status' => Complaint::STATUS_MENUNGGU,
            'new_status' => Complaint::STATUS_DIPROSES,
            'note' => 'Petugas teknis pipa PDAM sedang melakukan pengecekan kebocoran pipa transmisi intake.',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        ComplaintResponse::create([
            'complaint_id' => $complaint2->id,
            'user_id' => $admin->id,
            'response' => 'Pengaduan telah kami koordinasikan dengan PDAM Tirta Sejuk Gayo Lues. Ditemukan pipa pecah di area intake gunung dan perbaikan sedang berjalan hari ini.',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        // 3. Laporan Diverifikasi
        $complaint3 = Complaint::create([
            'ticket_number' => 'GL-2026-000003',
            'user_id' => $warga2->id,
            'category_id' => $catKesehatan->id,
            'title' => '[DATA SIMULASI] Ketiadaan Stok Obat Batuk Anak di Pustu Rikit Dekat',
            'description' => 'Masyarakat yang membawa balita berobat di Puskesmas Pembantu (Pustu) Rikit Dekat terpaksa membeli obat mandiri ke apotek luar kecamatan karena stok obat dasar kosong sejak minggu lalu.',
            'location' => 'Pustu Rikit Dekat, Kec. Kutapanjang',
            'kecamatan' => 'Kutapanjang',
            'desa' => 'Rikit Dekat',
            'incident_date' => Carbon::now()->subDays(2)->toDateString(),
            'photo_path' => null,
            'status' => Complaint::STATUS_DIVERIFIKASI,
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(1),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint3->id,
            'changed_by' => $admin->id,
            'old_status' => null,
            'new_status' => Complaint::STATUS_MENUNGGU,
            'note' => 'Laporan diterima.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint3->id,
            'changed_by' => $admin->id,
            'old_status' => Complaint::STATUS_MENUNGGU,
            'new_status' => Complaint::STATUS_DIVERIFIKASI,
            'note' => 'Laporan valid dan telah diteruskan ke Dinas Kesehatan Kabupaten Gayo Lues.',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        // 4. Laporan Menunggu Verifikasi
        $complaint4 = Complaint::create([
            'ticket_number' => 'GL-2026-000004',
            'user_id' => $warga2->id,
            'category_id' => $catLingkungan->id,
            'title' => '[DATA SIMULASI] Penumpukan Sampah Liar di Pinggir Sungai Terangun',
            'description' => 'Terdapat oknum yang membuang sampah domestik dalam jumlah besar di bantaran sungai, menimbulkan bau menyengat dan mengotori aliran air sungai.',
            'location' => 'Bantaran Sungai Kampung Padang, Terangun',
            'kecamatan' => 'Terangun',
            'desa' => 'Padang',
            'incident_date' => Carbon::now()->subDay()->toDateString(),
            'photo_path' => null,
            'status' => Complaint::STATUS_MENUNGGU,
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => Carbon::now()->subDay(),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint4->id,
            'changed_by' => $warga2->id,
            'old_status' => null,
            'new_status' => Complaint::STATUS_MENUNGGU,
            'note' => 'Pengaduan baru diajukan oleh masyarakat.',
            'created_at' => Carbon::now()->subDay(),
        ]);

        // 5. Laporan Ditolak
        $complaint5 = Complaint::create([
            'ticket_number' => 'GL-2026-000005',
            'user_id' => $warga1->id,
            'category_id' => $catPendidikan->id,
            'title' => '[DATA SIMULASI] Pengaduan Sengketa Tanah Pribadi Antar Keluarga',
            'description' => 'Ada klaim kepemilikan tanah pekarangan rumah antara kerabat dekat yang belum terselesaikan.',
            'location' => 'Desa Kampung Jawa',
            'kecamatan' => 'Blangkejeren',
            'desa' => 'Kampung Jawa',
            'incident_date' => Carbon::now()->subDays(5)->toDateString(),
            'photo_path' => null,
            'status' => Complaint::STATUS_DITOLAK,
            'rejection_reason' => 'Pengaduan ditolak karena merupakan sengketa perdata pribadi antarkeluarga dan berada di luar wewenang pelayanan publik pemerintah daerah. Disarankan untuk diselesaikan melalui mediasi Pengulu/Kepala Desa setempat atau pengadilan negeri.',
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(4),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint5->id,
            'changed_by' => $warga1->id,
            'old_status' => null,
            'new_status' => Complaint::STATUS_MENUNGGU,
            'note' => 'Laporan masuk.',
            'created_at' => Carbon::now()->subDays(5),
        ]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint5->id,
            'changed_by' => $admin->id,
            'old_status' => Complaint::STATUS_MENUNGGU,
            'new_status' => Complaint::STATUS_DITOLAK,
            'note' => 'Laporan tidak memenuhi kriteria pengaduan pelayanan publik daerah.',
            'created_at' => Carbon::now()->subDays(4),
        ]);
    }
}

