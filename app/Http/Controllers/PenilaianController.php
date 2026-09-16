<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Penilaian;
use App\Models\VarianRoti;
use App\Services\SawService;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $selectedPeriodeId = $request->get('periode_id', $periodes->first()?->id);
        $periode = $periodes->where('id', $selectedPeriodeId)->first();

        $kriterias = Kriteria::orderBy('kode', 'asc')->get();
        $varians = VarianRoti::orderBy('kode', 'asc')->get();

        // Siapkan matrix nilai yang sudah tersimpan
        $matrixX = [];
        if ($periode) {
            $penilaians = Penilaian::where('periode_id', $periode->id)->get();
            foreach ($penilaians as $p) {
                $matrixX[$p->varian_roti_id][$p->kriteria_id] = $p->nilai;
            }
        }

        return view('penilaian.index', compact(
            'periodes',
            'periode',
            'kriterias',
            'varians',
            'matrixX'
        ));
    }

    public function store(Request $request, Periode $periode)
    {
        $penilaianData = $request->input('nilai', []);

        foreach ($penilaianData as $varianId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                Penilaian::updateOrCreate(
                    [
                        'periode_id' => $periode->id,
                        'varian_roti_id' => $varianId,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'nilai' => (float)$nilai,
                    ]
                );
            }
        }

        // Jalankan perhitungan SAW otomatis setelah data disimpan
        $sawService = new SawService();
        $hasil = $sawService->hitung($periode);
        if ($hasil['status']) {
            $sawService->simpanHasil($periode, $hasil['hasil_perankingan']);
        }

        return redirect()->route('penilaian.index', ['periode_id' => $periode->id])
            ->with('success', 'Data operasional produksi periode ' . $periode->nama_periode . ' berhasil disimpan dan otomatis dihitung dengan metode SAW.');
    }
}
