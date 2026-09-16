@extends('layouts.app')

@section('title', 'Data Operasional & Matriks Keputusan (X)')

@section('content')
<div class="mb-4">
    <!-- Header with Period Filter -->
    <div class="card-custom p-3 mb-4">
        <div class="row align-items-center g-3">
            <div class="col-md-7">
                <h4 class="fw-bold text-dark mb-1">Data Operasional Produksi (Matriks X)</h4>
                <p class="text-muted small mb-0">Input data riil operasional untuk setiap varian roti berdasarkan 5 kriteria penentu prioritas produksi</p>
            </div>
            <div class="col-md-5">
                <form action="{{ route('penilaian.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    <label for="periode_id" class="small fw-semibold text-muted text-nowrap">Pilih Periode:</label>
                    <select name="periode_id" id="periode_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach ($periodes as $p)
                            <option value="{{ $p->id }}" {{ ($periode && $periode->id == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_periode }} ({{ ucfirst($p->status) }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    @if(!$periode)
        <div class="alert alert-warning border-0 p-4 text-center">
            <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
            <strong>Belum ada periode yang dipilih atau dibuat.</strong>
            <p class="small text-muted mb-3">Silakan buat periode bulanan terlebih dahulu untuk memulai pengisian data penilaian.</p>
            <a href="{{ route('periode.create') }}" class="btn btn-amber btn-sm">Buat Periode Sekarang</a>
        </div>
    @else
        <!-- Information Box -->
        <div class="row g-3 mb-3">
            <div class="col-12">
                <div class="alert alert-info border-0 py-2 px-3 d-flex align-items-center justify-content-between mb-0" style="font-size: 0.85rem;">
                    <div>
                        <i class="bi bi-info-circle-fill me-1"></i> Periode Aktif: <strong>{{ $periode->nama_periode }}</strong>
                        <span class="ms-2 badge {{ $periode->status === 'divalidasi' ? 'bg-success' : 'bg-primary' }}">
                            {{ strtoupper($periode->status) }}
                        </span>
                    </div>
                    <div>
                        <a href="{{ route('perhitungan.index', ['periode_id' => $periode->id]) }}" class="btn btn-sm btn-outline-primary bg-white">
                            <i class="bi bi-calculator"></i> Lihat Langkah Perhitungan SAW
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matrix Form -->
        <form action="{{ route('penilaian.store', $periode) }}" method="POST">
            @csrf

            <div class="card-custom overflow-hidden mb-4">
                <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0">Tabel Nilai Alternatif per Kriteria (Matriks Keputusan X)</h6>
                    <small class="text-muted">Nilai akan dinormalisasi sesuai rumus Benefit/Cost</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0 text-nowrap">
                        <thead class="table-light text-center">
                            <tr>
                                <th rowspan="2" class="align-middle" style="width: 60px;">Kode</th>
                                <th rowspan="2" class="align-middle text-start">Alternatif (Varian Roti)</th>
                                @foreach ($kriterias as $k)
                                    <th>
                                        <div class="fw-bold text-dark">{{ $k->kode }}</div>
                                        <div class="small fw-semibold text-secondary" style="font-size: 0.8rem;">{{ $k->nama }}</div>
                                        <span class="badge {{ $k->sifat === 'benefit' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $k->sifat === 'benefit' ? 'text-success' : 'text-danger' }} border" style="font-size: 0.65rem;">
                                            {{ strtoupper($k->sifat) }} ({{ round($k->bobot * 100) }}%)
                                        </span>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="bg-light text-muted" style="font-size: 0.75rem;">
                                @foreach ($kriterias as $k)
                                    <th>{{ $k->satuan ?? 'Nilai' }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($varians as $v)
                                <tr>
                                    <td class="text-center fw-bold bg-light">
                                        <span class="badge bg-secondary">{{ $v->kode }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $v->nama_varian }}</div>
                                        <small class="text-muted">{{ $v->kategori }}</small>
                                    </td>
                                    @foreach ($kriterias as $k)
                                        @php
                                            $val = $matrixX[$v->id][$k->id] ?? 0;
                                        @endphp
                                        <td style="min-width: 130px;">
                                            @can('manage-data')
                                                <input type="number" step="any" min="0" 
                                                    class="form-control form-control-sm text-center fw-semibold" 
                                                    name="nilai[{{ $v->id }}][{{ $k->id }}]" 
                                                    value="{{ $val }}" 
                                                    required>
                                            @else
                                                <div class="text-center fw-semibold text-dark py-1">
                                                    {{ number_format($val, 0, ',', '.') }}
                                                </div>
                                            @endcan
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @can('manage-data')
                    <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Menyimpan data akan otomatis memproses perhitungan normalisasi matriks dan skor preferensi SAW.
                        </small>
                        <button type="submit" class="btn btn-amber shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan & Jalankan SAW Otomatis
                        </button>
                    </div>
                @endcan
            </div>
        </form>
    @endif
</div>
@endsection
