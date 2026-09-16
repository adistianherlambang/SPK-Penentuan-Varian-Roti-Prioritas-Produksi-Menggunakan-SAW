@extends('layouts.app')

@section('title', 'Edit Kriteria ' . $kriteria->kode)

@section('content')
<div class="mb-4" style="max-width: 700px;">
    <div class="mb-3">
        <a href="{{ route('kriteria.index') }}" class="btn btn-sm btn-light border text-muted">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kriteria
        </a>
    </div>

    <div class="card-custom p-4">
        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
            <span class="badge bg-dark fs-6">{{ $kriteria->kode }}</span>
            <h5 class="fw-bold text-dark mb-0">Ubah Kriteria: {{ $kriteria->nama }}</h5>
        </div>

        <form action="{{ route('kriteria.update', $kriteria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Kriteria</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $kriteria->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sifat" class="form-label fw-semibold">Sifat (Atribut)</label>
                    <select class="form-select @error('sifat') is-invalid @enderror" id="sifat" name="sifat" required>
                        <option value="benefit" {{ old('sifat', $kriteria->sifat) === 'benefit' ? 'selected' : '' }}>Benefit (Keuntungan / Lebih besar lebih baik)</option>
                        <option value="cost" {{ old('sifat', $kriteria->sifat) === 'cost' ? 'selected' : '' }}>Cost (Biaya / Lebih kecil lebih baik)</option>
                    </select>
                    @error('sifat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="bobot" class="form-label fw-semibold">Bobot Relatif (W)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" max="1" class="form-control @error('bobot') is-invalid @enderror" id="bobot" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required>
                        <span class="input-group-text bg-light text-muted">Desimal (0-1)</span>
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">Contoh: 0.30 untuk bobot 30%</small>
                    @error('bobot')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="satuan" class="form-label fw-semibold">Satuan Pengukuran</label>
                <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $kriteria->satuan) }}" placeholder="Contoh: Pcs, Rupiah, Menit">
                @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="keterangan" class="form-label fw-semibold">Keterangan Tambahan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $kriteria->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('kriteria.index') }}" class="btn btn-light border">Batal</a>
                <button type="submit" class="btn btn-amber">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
