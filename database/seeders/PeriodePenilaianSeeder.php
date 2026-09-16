<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;
use App\Models\Kriteria;
use App\Models\VarianRoti;
use App\Models\Penilaian;
use App\Services\SawService;

class PeriodePenilaianSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Periode Aktif Bulanan (Oktober 2026)
        $periode = Periode::updateOrCreate(
            ['bulan' => 10, 'tahun' => 2026],
            [
                'nama_periode' => 'Periode Produksi Oktober 2026',
                'status' => 'draft',
            ]
        );

        $kriterias = Kriteria::all()->keyBy('kode');
        $varians = VarianRoti::all()->keyBy('kode');

        // Data sampel matriks keputusan X yang realistis di pabrik Pelangi Nusantara Food:
        // C1: Volume Penjualan (Pcs, Benefit)
        // C2: Keuntungan per Pcs (Rupiah, Benefit)
        // C3: Stok Bahan Baku (% kesiapan, Benefit)
        // C4: Waktu Produksi (Menit/Batch, Cost)
        // C5: Sisa Stok Gudang (Pcs, Cost)
        $dataPenilaian = [
            'A1' => ['C1' => 2400, 'C2' => 2500, 'C3' => 95, 'C4' => 45, 'C5' => 120],
            'A2' => ['C1' => 3100, 'C2' => 2300, 'C3' => 90, 'C4' => 40, 'C5' => 85],
            'A3' => ['C1' => 2800, 'C2' => 3000, 'C3' => 85, 'C4' => 50, 'C5' => 95],
            'A4' => ['C1' => 1950, 'C2' => 5200, 'C3' => 80, 'C4' => 65, 'C5' => 70],
            'A5' => ['C1' => 1650, 'C2' => 3400, 'C3' => 75, 'C4' => 55, 'C5' => 110],
            'A6' => ['C1' => 1200, 'C2' => 2200, 'C3' => 70, 'C4' => 40, 'C5' => 160],
            'A7' => ['C1' => 2200, 'C2' => 2800, 'C3' => 85, 'C4' => 48, 'C5' => 100],
            'A8' => ['C1' => 1400, 'C2' => 2400, 'C3' => 75, 'C4' => 50, 'C5' => 140],
        ];

        foreach ($dataPenilaian as $vKode => $kriteriaValues) {
            if (isset($varians[$vKode])) {
                $varianId = $varians[$vKode]->id;
                foreach ($kriteriaValues as $cKode => $nilai) {
                    if (isset($kriterias[$cKode])) {
                        Penilaian::updateOrCreate(
                            [
                                'periode_id' => $periode->id,
                                'varian_roti_id' => $varianId,
                                'kriteria_id' => $kriterias[$cKode]->id,
                            ],
                            ['nilai' => $nilai]
                        );
                    }
                }
            }
        }

        // Lakukan eksekusi perhitungan awal agar langsung tersimpan di hasil_saw_details
        $sawService = new SawService();
        $hasil = $sawService->hitung($periode);
        if ($hasil['status']) {
            $sawService->simpanHasil($periode, $hasil['hasil_perankingan']);
        }
    }
}
