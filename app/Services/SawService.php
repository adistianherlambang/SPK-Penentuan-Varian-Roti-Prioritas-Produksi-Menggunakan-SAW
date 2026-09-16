<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Penilaian;
use App\Models\VarianRoti;
use App\Models\HasilSawDetail;
use Illuminate\Support\Facades\DB;

class SawService
{
    /**
     * Hitung metode Simple Additive Weighting (SAW) untuk periode tertentu.
     * Sesuai dengan rumus pada Proposal Skripsi Alfonso Yanuarvi:
     * 1. Matriks Keputusan (X)
     * 2. Normalisasi Matriks (R) -> Benefit: Xij / Max(Xj), Cost: Min(Xj) / Xij
     * 3. Preferensi (Vi) = SUM(Wj * Rij)
     * 4. Perangkingan
     */
    public function hitung(Periode $periode): array
    {
        $kriterias = Kriteria::orderBy('kode', 'asc')->get();
        $varians = VarianRoti::orderBy('kode', 'asc')->get();

        if ($kriterias->isEmpty() || $varians->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Data Kriteria atau Data Varian Roti masih kosong.',
            ];
        }

        // Ambil data penilaian yang sudah diinput untuk periode ini
        $penilaians = Penilaian::where('periode_id', $periode->id)->get();

        if ($penilaians->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Belum ada data operasional/penilaian untuk periode ini.',
            ];
        }

        // 1. Susun Matriks Keputusan X[i][j]
        $matrixX = [];
        foreach ($varians as $v) {
            foreach ($kriterias as $k) {
                $p = $penilaians->where('varian_roti_id', $v->id)->where('kriteria_id', $k->id)->first();
                $matrixX[$v->id][$k->id] = $p ? (float)$p->nilai : 0.0;
            }
        }

        // 2. Cari Nilai Max dan Min untuk setiap Kriteria j
        $kriteriaStats = [];
        $totalBobot = $kriterias->sum('bobot');

        foreach ($kriterias as $k) {
            $columnValues = [];
            foreach ($varians as $v) {
                $columnValues[] = $matrixX[$v->id][$k->id];
            }

            $max = count($columnValues) ? max($columnValues) : 0;
            $min = count($columnValues) ? min($columnValues) : 0;

            // Bobot ternormalisasi jika sum bobot != 1
            $bobotTernormalisasi = $totalBobot > 0 ? ($k->bobot / $totalBobot) : 0;

            $kriteriaStats[$k->id] = [
                'kriteria' => $k,
                'max' => $max,
                'min' => $min,
                'bobot_normal' => $bobotTernormalisasi,
            ];
        }

        // 3. Hitung Matriks Ternormalisasi R[i][j]
        $matrixR = [];
        foreach ($varians as $v) {
            foreach ($kriterias as $k) {
                $val = $matrixX[$v->id][$k->id];
                $max = $kriteriaStats[$k->id]['max'];
                $min = $kriteriaStats[$k->id]['min'];

                if ($k->sifat === 'benefit') {
                    // Rumus Benefit: Rij = Xij / Max(Xj)
                    $matrixR[$v->id][$k->id] = ($max > 0) ? round($val / $max, 5) : 0.0;
                } else {
                    // Rumus Cost: Rij = Min(Xj) / Xij
                    $matrixR[$v->id][$k->id] = ($val > 0) ? round($min / $val, 5) : 0.0;
                }
            }
        }

        // 4. Hitung Nilai Preferensi Vi = SUM( Wj * Rij )
        $hasilPerankingan = [];
        foreach ($varians as $v) {
            $totalVi = 0.0;
            $breakdown = [];

            foreach ($kriterias as $k) {
                $w = $kriteriaStats[$k->id]['bobot_normal'];
                $r = $matrixR[$v->id][$k->id];
                $kali = round($w * $r, 5);
                $totalVi += $kali;
                $breakdown[$k->id] = [
                    'r' => $r,
                    'w' => $w,
                    'hasil_kali' => $kali,
                ];
            }

            $totalVi = round($totalVi, 5);

            $hasilPerankingan[] = [
                'varian_id' => $v->id,
                'varian' => $v,
                'nilai_preferensi' => $totalVi,
                'breakdown' => $breakdown,
            ];
        }

        // Urutkan nilai preferensi terbesar ke terkecil (Descending)
        usort($hasilPerankingan, function ($a, $b) {
            if ($a['nilai_preferensi'] == $b['nilai_preferensi']) {
                return 0;
            }
            return ($a['nilai_preferensi'] > $b['nilai_preferensi']) ? -1 : 1;
        });

        // 5. Berikan Ranking & Rekomendasi
        $totalAlternatif = count($hasilPerankingan);
        foreach ($hasilPerankingan as $idx => &$item) {
            $rank = $idx + 1;
            $item['ranking'] = $rank;

            // Klasifikasi rekomendasi prioritas produksi
            if ($rank <= ceil($totalAlternatif * 0.40) || $item['nilai_preferensi'] >= 0.80) {
                $item['rekomendasi'] = 'Prioritas Utama';
                $item['rekomendasi_badge'] = 'success';
                $item['catatan'] = 'Tingkatkan kapasitas produksi bulanan untuk memenuhi permintaan pasar.';
            } elseif ($rank <= ceil($totalAlternatif * 0.75) || $item['nilai_preferensi'] >= 0.60) {
                $item['rekomendasi'] = 'Prioritas Sedang';
                $item['rekomendasi_badge'] = 'warning';
                $item['catatan'] = 'Produksi sesuai rata-rata permintaan atau pesanan terkonfirmasi.';
            } else {
                $item['rekomendasi'] = 'Prioritas Rendah';
                $item['rekomendasi_badge'] = 'secondary';
                $item['catatan'] = 'Batasi produksi untuk mencegah penumpukan sisa stok gudang.';
            }
        }
        unset($item);

        return [
            'status' => true,
            'periode' => $periode,
            'kriterias' => $kriterias,
            'varians' => $varians,
            'matrix_x' => $matrixX,
            'kriteria_stats' => $kriteriaStats,
            'matrix_r' => $matrixR,
            'hasil_perankingan' => $hasilPerankingan,
        ];
    }

    /**
     * Simpan hasil kalkulasi SAW ke dalam database tabel hasil_saw_details
     */
    public function simpanHasil(Periode $periode, array $hasilPerankingan): void
    {
        DB::transaction(function () use ($periode, $hasilPerankingan) {
            // Hapus hasil lama pada periode ini jika ada
            HasilSawDetail::where('periode_id', $periode->id)->delete();

            foreach ($hasilPerankingan as $item) {
                HasilSawDetail::create([
                    'periode_id' => $periode->id,
                    'varian_roti_id' => $item['varian_id'],
                    'nilai_preferensi' => $item['nilai_preferensi'],
                    'ranking' => $item['ranking'],
                    'rekomendasi' => $item['rekomendasi'],
                    'catatan' => $item['catatan'],
                ]);
            }

            if ($periode->status === 'draft') {
                $periode->update(['status' => 'dihitung']);
            }
        });
    }
}
