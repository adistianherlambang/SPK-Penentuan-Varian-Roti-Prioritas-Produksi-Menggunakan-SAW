@extends('layouts.app')

@section('title', 'Buat Periode Baru')

@section('content')
<div class="d-flex flex-column gap-4" style="max-width: 600px;">
    <div>
        <a href="{{ route('periode.index') }}" class="btn btn-sm btn-pill-light">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Periode
        </a>
    </div>

    <div class="card-custom p-4 bg-white">
        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom border-light">Buat Periode Penilaian Produksi Baru</h5>

        <form action="{{ route('periode.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_periode" class="form-label fw-semibold text-dark">Nama Periode</label>
                <input type="text" class="form-control @error('nama_periode') is-invalid @enderror" id="nama_periode" name="nama_periode" value="{{ old('nama_periode', 'Periode Produksi ' . date('F Y')) }}" required>
                @error('nama_periode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="bulan" class="form-label fw-semibold text-dark">Bulan</label>
                    <select class="form-select @error('bulan') is-invalid @enderror" id="bulan" name="bulan" required>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ old('bulan', $bulanSekarang) == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }} ({{ sprintf('%02d', $m) }})
                            </option>
                        @endfor
                    </select>
                    @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tahun" class="form-label fw-semibold text-dark">Tahun</label>
                    <input type="number" min="2020" max="2050" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $tahunSekarang) }}" required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('periode.index') }}" class="btn btn-pill-light">Batal</a>
                <button type="submit" class="btn btn-coral">
                    <i class="bi bi-calendar-plus me-1"></i> Simpan Periode
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
