@extends('layouts.app')

@section('title', 'Edit Kriteria')

@section('content')
<div class="d-flex flex-column gap-4" style="max-width: 650px;">
    <div>
        <a href="{{ route('kriteria.index') }}" class="btn btn-sm btn-pill-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-custom p-4 bg-white">
        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom border-light">
            <span class="badge badge-coral-pill fs-6">{{ $kriteria->kode }}</span>
            <h5 class="fw-bold text-dark mb-0">{{ $kriteria->nama }}</h5>
        </div>

        <form action="{{ route('kriteria.update', $kriteria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold text-dark small">Nama Kriteria</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $kriteria->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sifat" class="form-label fw-semibold text-dark small">Sifat</label>
                    <select class="form-select @error('sifat') is-invalid @enderror" id="sifat" name="sifat" required>
                        <option value="benefit" {{ old('sifat', $kriteria->sifat) === 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('sifat', $kriteria->sifat) === 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                    @error('sifat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="bobot" class="form-label fw-semibold text-dark small">Bobot (W)</label>
                    <input type="number" step="0.01" min="0" max="1" class="form-control @error('bobot') is-invalid @enderror" id="bobot" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required placeholder="Contoh: 0.30">
                    @error('bobot')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="satuan" class="form-label fw-semibold text-dark small">Satuan</label>
                <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $kriteria->satuan) }}" placeholder="Pcs, Rupiah, dll">
                @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="keterangan" class="form-label fw-semibold text-dark small">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="2">{{ old('keterangan', $kriteria->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('kriteria.index') }}" class="btn btn-pill-light">Batal</a>
                <button type="submit" class="btn btn-coral">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
