<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\HasilSawDetail;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $selectedPeriodeId = $request->input('periode_id', $periodes->first()?->id);
        $periode = $periodes->where('id', $selectedPeriodeId)->first();

        $hasilSaw = collect();
        if ($periode) {
            $hasilSaw = HasilSawDetail::with('varianRoti')
                ->where('periode_id', $periode->id)
                ->orderBy('ranking', 'asc')
                ->get();
        }

        return view('laporan.index', compact('periodes', 'periode', 'hasilSaw'));
    }

    public function cetak(Periode $periode)
    {
        $hasilSaw = HasilSawDetail::with('varianRoti')
            ->where('periode_id', $periode->id)
            ->orderBy('ranking', 'asc')
            ->get();

        return view('laporan.cetak', compact('periode', 'hasilSaw'));
    }
}
