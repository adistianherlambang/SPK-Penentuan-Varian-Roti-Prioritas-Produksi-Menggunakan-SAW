<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\VarianRoti;
use App\Models\HasilSawDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKriteria = Kriteria::count();
        $totalVarian = VarianRoti::count();
        $totalPeriode = Periode::count();

        // Ambil periode terbaru yang sudah dihitung atau draft
        $periodeTerbaru = Periode::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        $hasilTerbaru = collect();
        if ($periodeTerbaru) {
            $hasilTerbaru = HasilSawDetail::with('varianRoti')
                ->where('periode_id', $periodeTerbaru->id)
                ->orderBy('ranking', 'asc')
                ->get();
        }

        return view('dashboard.index', compact(
            'totalKriteria',
            'totalVarian',
            'totalPeriode',
            'periodeTerbaru',
            'hasilTerbaru'
        ));
    }
}
