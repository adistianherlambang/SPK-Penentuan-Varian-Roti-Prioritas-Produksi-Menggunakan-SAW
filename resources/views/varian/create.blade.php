@extends('layouts.app')

@section('title', 'Tambah Varian Roti')

@section('content')
<div class="d-flex flex-column gap-4" style="max-width: 700px;">
    <div>
        <a href="{{ route('varian.index') }}" class="btn btn-sm btn-pill-light">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Varian
        </a>
    </div>

    <div class="card-custom p-4 bg-white">
        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom border-light">Tambah Varian Roti Baru</h5>

        <form action="{{ route('varian.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kode" class="form-label fw-semibold text-dark">Kode Alternatif</label>
                    <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $defaultKode) }}" required placeholder="Contoh: A9">
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label for="nama_varian" class="form-label fw-semibold text-dark">Nama Varian Roti</label>
                    <input type="text" class="form-control @error('nama_varian') is-invalid @enderror" id="nama_varian" name="nama_varian" value="{{ old('nama_varian') }}" required placeholder="Contoh: Roti Kacang Hijau">
                    @error('nama_varian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label fw-semibold text-dark">Kategori Produk</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', 'Roti Manis') }}" required placeholder="Contoh: Roti Manis, Roti Sobek, Roti Gurih">
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="harga_jual" class="form-label fw-semibold text-dark">Harga Jual (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">Rp</span>
                        <input type="number" step="500" min="0" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', 0) }}" required>
                    </div>
                    @error('harga_jual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="estimasi_keuntungan" class="form-label fw-semibold text-dark">Estimasi Margin Keuntungan (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">Rp</span>
                        <input type="number" step="100" min="0" class="form-control @error('estimasi_keuntungan') is-invalid @enderror" id="estimasi_keuntungan" name="estimasi_keuntungan" value="{{ old('estimasi_keuntungan', 0) }}" required>
                    </div>
                    @error('estimasi_keuntungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-semibold text-dark">Deskripsi / Keterangan</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Karakteristik roti, bahan isian, daya tahan...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('varian.index') }}" class="btn btn-pill-light">Batal</a>
                <button type="submit" class="btn btn-coral">
                    <i class="bi bi-plus-circle me-1"></i> Simpan Varian Roti
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
