<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin (Ibu Dian - Sesuai Batasan Masalah Proposal Halaman 3 & 47)
        User::updateOrCreate(
            ['email' => 'admin@pelangifood.com'],
            [
                'name' => 'Ibu Dian',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'jabatan' => 'Admin Operasional & Pengelolaan Data',
            ]
        );

        // 2. Akun Manajemen (Bapak Wisnu Nur Yadi - Manajer Pelangi Nusantara Food)
        User::updateOrCreate(
            ['email' => 'manajemen@pelangifood.com'],
            [
                'name' => 'Bapak Wisnu Nur Yadi',
                'password' => Hash::make('manajemen123'),
                'role' => 'manajemen',
                'jabatan' => 'Manajer Operasional / Pengambil Keputusan',
            ]
        );
    }
}
