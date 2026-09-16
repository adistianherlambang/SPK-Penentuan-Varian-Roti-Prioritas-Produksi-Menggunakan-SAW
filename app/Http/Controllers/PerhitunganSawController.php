<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Services\SawService;
use Illuminate\Http\Request;

class PerhitunganSawController extends Controller
{
    public function index(Request $request, SawService $sawService)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $selectedPeriodeId = $request->get('periode_id', $periodes->first()?->id);
        $periode = $periodes->where('id', $selectedPeriodeId)->first();

        $hasilSaw = null;
        if ($periode) {
            $hasilSaw = $sawService->hitung($periode);
        }

        return view('perhitungan.index', compact('periodes', 'periode', 'hasilSaw'));
    }

    public function hitungUlang(Periode $periode, SawService $sawService)
    {
        $hasil = $sawService->hitung($periode);
        if (!$hasil['status']) {
            return back()->with('error', $hasil['message']);
        }

        $sawService->simpanHasil($periode, $hasil['hasil_perankingan']);

        return back()->with('success', 'Perhitungan SAW untuk periode ' . $periode->nama_periode . ' berhasil diperbarui dan disimpan.');
    }
}
