<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VarianRoti;

class VarianRotiSeeder extends Seeder
{
    public function run(): void
    {
        // Alternatif Varian Roti di Pelangi Nusantara Food (Roti Purnama)
        $varians = [
            [
                'kode' => 'A1',
                'nama_varian' => 'Roti Sisir Mentega Manis',
                'kategori' => 'Roti Sisir Tradisional',
                'harga_jual' => 8000,
                'estimasi_keuntungan' => 2500,
                'deskripsi' => 'Roti sisir legendaris bertekstur lembut dengan olesan mentega manis khas Purnama.',
            ],
            [
                'kode' => 'A2',
                'nama_varian' => 'Roti Coklat Lumer',
                'kategori' => 'Roti Manis',
                'harga_jual' => 7500,
                'estimasi_keuntungan' => 2300,
                'deskripsi' => 'Varian favorit anak-anak dan remaja dengan pasta coklat premium yang meleleh.',
            ],
            [
                'kode' => 'A3',
                'nama_varian' => 'Roti Keju Spesial',
                'kategori' => 'Roti Manis',
                'harga_jual' => 9000,
                'estimasi_keuntungan' => 3000,
                'deskripsi' => 'Roti manis dengan taburan keju cheddar parut melimpah dan isian butter cream lembut.',
            ],
            [
                'kode' => 'A4',
                'nama_varian' => 'Roti Sobek Kombinasi Coklat Keju',
                'kategori' => 'Roti Sobek',
                'harga_jual' => 16000,
                'estimasi_keuntungan' => 5200,
                'deskripsi' => 'Roti porsi keluarga dengan perpaduan isian selai coklat dan potongan keju gurih.',
            ],
            [
                'kode' => 'A5',
                'nama_varian' => 'Roti Abon Ayam Pedas Manis',
                'kategori' => 'Roti Gurih / Savory',
                'harga_jual' => 10000,
                'estimasi_keuntungan' => 3400,
                'deskripsi' => 'Roti gurih dengan topping abon ayam asli yang dipadukan dengan saus mayonnaise spesial.',
            ],
            [
                'kode' => 'A6',
                'nama_varian' => 'Roti Srikaya Tradisional',
                'kategori' => 'Roti Manis',
                'harga_jual' => 7000,
                'estimasi_keuntungan' => 2200,
                'deskripsi' => 'Roti beraroma daun pandan dengan selai srikaya buatan rumahan bertekstur legit.',
            ],
            [
                'kode' => 'A7',
                'nama_varian' => 'Roti Pisang Coklat Crispy',
                'kategori' => 'Roti Manis',
                'harga_jual' => 8500,
                'estimasi_keuntungan' => 2800,
                'deskripsi' => 'Kombinasi potongan pisang raja matang berpadu lelehan coklat manis.',
            ],
            [
                'kode' => 'A8',
                'nama_varian' => 'Roti Kacang Merah (Red Bean)',
                'kategori' => 'Roti Manis',
                'harga_jual' => 7500,
                'estimasi_keuntungan' => 2400,
                'deskripsi' => 'Isian pasta kacang merah halus dengan tingkat kemanisan yang pas.',
            ],
        ];

        foreach ($varians as $v) {
            VarianRoti::updateOrCreate(['kode' => $v['kode']], $v);
        }
    }
}
