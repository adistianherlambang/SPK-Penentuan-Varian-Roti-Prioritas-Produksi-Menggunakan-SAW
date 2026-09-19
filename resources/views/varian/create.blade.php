@extends('layouts.app')

@section('title', 'Tambah Varian')

@section('content')
<div class="d-flex flex-column gap-4" style="max-width: 650px;">
    <div>
        <a href="{{ route('varian.index') }}" class="btn btn-sm btn-pill-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-custom p-4 bg-white">
        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom border-light">Tambah Varian Baru</h5>

        <form action="{{ route('varian.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kode" class="form-label fw-semibold text-dark small">Kode</label>
                    <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $defaultKode) }}" required placeholder="A9">
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label for="nama_varian" class="form-label fw-semibold text-dark small">Nama Varian</label>
                    <input type="text" class="form-control @error('nama_varian') is-invalid @enderror" id="nama_varian" name="nama_varian" value="{{ old('nama_varian') }}" required placeholder="Nama varian roti">
                    @error('nama_varian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label fw-semibold text-dark small">Kategori</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', 'Roti Manis') }}" required placeholder="Kategori">
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="harga_jual" class="form-label fw-semibold text-dark small">Harga (Rp)</label>
                    <input type="number" step="500" min="0" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', 0) }}" required>
                    @error('harga_jual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="estimasi_keuntungan" class="form-label fw-semibold text-dark small">Estimasi Margin (Rp)</label>
                    <input type="number" step="100" min="0" class="form-control @error('estimasi_keuntungan') is-invalid @enderror" id="estimasi_keuntungan" name="estimasi_keuntungan" value="{{ old('estimasi_keuntungan', 0) }}" required>
                    @error('estimasi_keuntungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-semibold text-dark small">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="2" placeholder="Keterangan singkat..."></textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('varian.index') }}" class="btn btn-pill-light">Batal</a>
                <button type="submit" class="btn btn-coral">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
