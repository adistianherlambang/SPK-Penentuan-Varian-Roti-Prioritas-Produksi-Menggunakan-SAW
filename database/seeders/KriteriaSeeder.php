<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // 5 Kriteria Penilaian Berdasarkan Proposal Skripsi (Halaman 3 & 47)
        $kriterias = [
            [
                'kode' => 'C1',
                'nama' => 'Volume Penjualan',
                'sifat' => 'benefit',
                'bobot' => 0.30,
                'satuan' => 'Pcs / Bulan',
                'keterangan' => 'Jumlah produk roti yang berhasil laku terjual ke pasar/pelanggan. Semakin tinggi semakin diprioritaskan.',
            ],
            [
                'kode' => 'C2',
                'nama' => 'Keuntungan (Profit Margin)',
                'sifat' => 'benefit',
                'bobot' => 0.25,
                'satuan' => 'Rupiah / Pcs',
                'keterangan' => 'Besaran margin laba bersih yang didapat dari setiap varian roti. Semakin tinggi semakin menguntungkan.',
            ],
            [
                'kode' => 'C3',
                'nama' => 'Stok Bahan Baku',
                'sifat' => 'benefit',
                'bobot' => 0.15,
                'satuan' => 'Persen (%) Kesiapan',
                'keterangan' => 'Ketersediaan bahan baku di gudang untuk memproduksi varian roti tersebut. Semakin siap stok bahan, semakin lancar proses produksi.',
            ],
            [
                'kode' => 'C4',
                'nama' => 'Waktu Produksi',
                'sifat' => 'cost',
                'bobot' => 0.15,
                'satuan' => 'Menit / Batch',
                'keterangan' => 'Durasi waktu yang diperlukan dari pengadonan hingga pemanggangan. Semakin singkat waktu proses, semakin efisien kapasitas pabrik.',
            ],
            [
                'kode' => 'C5',
                'nama' => 'Sisa Stok Gudang',
                'sifat' => 'cost',
                'bobot' => 0.15,
                'satuan' => 'Pcs',
                'keterangan' => 'Jumlah roti yang belum terjual di gudang penyimpanan. Semakin sedikit sisa stok, semakin perlu diproduksi kembali (mencegah penumpukan roti lama).',
            ],
        ];

        foreach ($kriterias as $k) {
            Kriteria::updateOrCreate(['kode' => $k['kode']], $k);
        }
    }
}
