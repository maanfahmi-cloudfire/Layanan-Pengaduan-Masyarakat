<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::updateOrCreate(
            ['email' => 'admin@gayolues.go.id'],
            [
                'name' => 'Administrator Gayo Lues',
                'phone' => '081269001234',
                'kecamatan' => 'Blangkejeren',
                'desa' => 'Kampung Jawa',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Masyarakat 1 (Warga Blangkejeren)
        User::updateOrCreate(
            ['email' => 'warga1@gayolues.id'],
            [
                'name' => 'Aman Mayak (Simulasi)',
                'phone' => '085277112233',
                'kecamatan' => 'Blangkejeren',
                'desa' => 'Bustanusalam',
                'password' => Hash::make('password123'),
                'role' => 'masyarakat',
            ]
        );

        // 3. Akun Masyarakat 2 (Warga Kutapanjang)
        User::updateOrCreate(
            ['email' => 'warga2@gayolues.id'],
            [
                'name' => 'Siti Khadijah (Simulasi)',
                'phone' => '082165443322',
                'kecamatan' => 'Kutapanjang',
                'desa' => 'Rikit Dekat',
                'password' => Hash::make('password123'),
                'role' => 'masyarakat',
            ]
        );
    }
}

