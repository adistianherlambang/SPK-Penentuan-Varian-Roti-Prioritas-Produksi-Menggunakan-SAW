<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::withCount(['penilaians', 'hasilSawDetails'])
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('periode.index', compact('periodes'));
    }

    public function create()
    {
        $bulanSekarang = (int)date('n');
        $tahunSekarang = (int)date('Y');
        return view('periode.create', compact('bulanSekarang', 'tahunSekarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => ['required', 'string', 'max:255'],
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2050'],
        ]);

        $periode = Periode::create([
            'nama_periode' => $request->nama_periode,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'status' => 'draft',
        ]);

        return redirect()->route('periode.index')->with('success', 'Periode ' . $periode->nama_periode . ' berhasil dibuat.');
    }

    public function validasi(Request $request, Periode $periode)
    {
        $request->validate([
            'catatan_manajemen' => ['nullable', 'string'],
        ]);

        $periode->update([
            'status' => 'divalidasi',
            'catatan_manajemen' => $request->catatan_manajemen,
            'tanggal_validasi' => now(),
        ]);

        return back()->with('success', 'Periode produksi berhasil divalidasi oleh Manajemen.');
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();
        return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus.');
    }
}
