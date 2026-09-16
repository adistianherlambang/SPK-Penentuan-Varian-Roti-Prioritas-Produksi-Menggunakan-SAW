<?php

namespace App\Http\Controllers;

use App\Models\VarianRoti;
use Illuminate\Http\Request;

class VarianRotiController extends Controller
{
    public function index()
    {
        $varians = VarianRoti::orderBy('kode', 'asc')->get();
        return view('varian.index', compact('varians'));
    }

    public function create()
    {
        // Auto-generate kode A1, A2, dst
        $last = VarianRoti::orderBy('id', 'desc')->first();
        $nextNum = $last ? ((int)substr($last->kode, 1) + 1) : 1;
        $defaultKode = 'A' . $nextNum;

        return view('varian.create', compact('defaultKode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:varian_rotis,kode'],
            'nama_varian' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'harga_jual' => ['required', 'numeric', 'min:0'],
            'estimasi_keuntungan' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        VarianRoti::create($validated);

        return redirect()->route('varian.index')->with('success', 'Varian roti berhasil ditambahkan.');
    }

    public function edit(VarianRoti $varian)
    {
        return view('varian.edit', compact('varian'));
    }

    public function update(Request $request, VarianRoti $varian)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:varian_rotis,kode,' . $varian->id],
            'nama_varian' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'harga_jual' => ['required', 'numeric', 'min:0'],
            'estimasi_keuntungan' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $varian->update($validated);

        return redirect()->route('varian.index')->with('success', 'Data varian roti berhasil diperbarui.');
    }

    public function destroy(VarianRoti $varian)
    {
        $varian->delete();
        return redirect()->route('varian.index')->with('success', 'Varian roti berhasil dihapus.');
    }
}
