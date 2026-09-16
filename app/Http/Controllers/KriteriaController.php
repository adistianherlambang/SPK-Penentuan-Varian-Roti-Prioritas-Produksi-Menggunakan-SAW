<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::orderBy('kode', 'asc')->get();
        $totalBobot = $kriterias->sum('bobot');

        return view('kriteria.index', compact('kriterias', 'totalBobot'));
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'sifat' => ['required', 'in:benefit,cost'],
            'bobot' => ['required', 'numeric', 'min:0', 'max:1'],
            'satuan' => ['nullable', 'string', 'max:50'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $kriteria->update($request->only(['nama', 'sifat', 'bobot', 'satuan', 'keterangan']));

        return redirect()->route('kriteria.index')->with('success', 'Kriteria ' . $kriteria->kode . ' berhasil diperbarui.');
    }
}
