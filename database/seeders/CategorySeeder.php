<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Infrastruktur dan Jalan',
                'description' => 'Pengaduan terkait kondisi jalan berlubang, jembatan rusak, drainase, dan fasilitas fisik daerah.',
                'icon' => 'truck',
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Pengaduan sarana dan prasarana sekolah, tenaga pendidik, bantuan siswa, dan mutu pendidikan.',
                'icon' => 'graduation-cap',
            ],
            [
                'name' => 'Kesehatan',
                'description' => 'Pengaduan layanan Puskesmas, RSUD Muhammad Ali Kasim, ketersediaan obat, dan tenaga medis.',
                'icon' => 'heart-pulse',
            ],
            [
                'name' => 'Lingkungan dan Kebersihan',
                'description' => 'Pengaduan pengelolaan sampah, pencemaran lingkungan, pencegahan longsor, dan kebersihan ruang publik.',
                'icon' => 'trees',
            ],
            [
                'name' => 'Pelayanan Administrasi',
                'description' => 'Pengaduan terkait pengurusan KTP, KK, perizinan, dan birokrasi pelayanan publik di Gayo Lues.',
                'icon' => 'file-text',
            ],
            [
                'name' => 'Air Bersih',
                'description' => 'Pengaduan distribusi air PDAM Tirta Sejuk, air keruh, kebocoran pipa, dan pasokan air bersih warga.',
                'icon' => 'droplets',
            ],
            [
                'name' => 'Fasilitas Umum',
                'description' => 'Pengaduan penerangan jalan umum, taman kota, pasar tradisional, dan tempat ibadah.',
                'icon' => 'building-2',
            ],
            [
                'name' => 'Lainnya',
                'description' => 'Pengaduan permasalahan masyarakat lainnya yang belum terakomodasi dalam kategori di atas.',
                'icon' => 'help-circle',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'icon' => $cat['icon'],
                    'is_active' => true,
                ]
            );
        }
    }
}

