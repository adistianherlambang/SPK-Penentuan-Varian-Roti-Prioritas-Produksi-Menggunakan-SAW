@extends('layouts.app')

@section('title', 'Ubah Varian Roti ' . $varian->kode)

@section('content')
<div class="mb-4" style="max-width: 700px;">
    <div class="mb-3">
        <a href="{{ route('varian.index') }}" class="btn btn-sm btn-light border text-muted">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Varian
        </a>
    </div>

    <div class="card-custom p-4">
        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
            <span class="badge bg-secondary fs-6">{{ $varian->kode }}</span>
            <h5 class="fw-bold text-dark mb-0">Ubah Data Varian: {{ $varian->nama_varian }}</h5>
        </div>

        <form action="{{ route('varian.update', $varian) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kode" class="form-label fw-semibold">Kode Alternatif</label>
                    <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $varian->kode) }}" required>
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label for="nama_varian" class="form-label fw-semibold">Nama Varian Roti</label>
                    <input type="text" class="form-control @error('nama_varian') is-invalid @enderror" id="nama_varian" name="nama_varian" value="{{ old('nama_varian', $varian->nama_varian) }}" required>
                    @error('nama_varian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label fw-semibold">Kategori Produk</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', $varian->kategori) }}" required>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="harga_jual" class="form-label fw-semibold">Harga Jual (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">Rp</span>
                        <input type="number" step="500" min="0" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $varian->harga_jual) }}" required>
                    </div>
                    @error('harga_jual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="estimasi_keuntungan" class="form-label fw-semibold">Estimasi Margin Keuntungan (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">Rp</span>
                        <input type="number" step="100" min="0" class="form-control @error('estimasi_keuntungan') is-invalid @enderror" id="estimasi_keuntungan" name="estimasi_keuntungan" value="{{ old('estimasi_keuntungan', $varian->estimasi_keuntungan) }}" required>
                    </div>
                    @error('estimasi_keuntungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi / Keterangan</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $varian->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('varian.index') }}" class="btn btn-light border">Batal</a>
                <button type="submit" class="btn btn-amber">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
