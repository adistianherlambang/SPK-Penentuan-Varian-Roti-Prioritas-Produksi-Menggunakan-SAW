@extends('layouts.app')

@section('title', 'Data Operasional & Matriks Keputusan (X)')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Header with Period Filter -->
    <div class="card-custom p-4 bg-white">
        <div class="row align-items-center g-3">
            <div class="col-md-7">
                <h4 class="fw-bold text-dark mb-1">Data Operasional Produksi (Matriks X)</h4>
                <p class="text-muted small mb-0">Input data riil operasional untuk setiap varian roti berdasarkan 5 kriteria penentu prioritas produksi</p>
            </div>
            <div class="col-md-5">
                <form action="{{ route('penilaian.index') }}" method="GET" class="d-flex align-items-center justify-content-md-end gap-2">
                    <label for="periode_id" class="small fw-semibold text-muted text-nowrap">Pilih Periode:</label>
                    <select name="periode_id" id="periode_id" class="select-pill" onchange="this.form.submit()">
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
        <div class="card-custom p-5 bg-white text-center">
            <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="background-color: #FEF2F2; color: #EF4444; width: 64px; height: 64px;">
                <i class="bi bi-calendar-x fs-2"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Belum ada periode yang dipilih atau dibuat</h5>
            <p class="small text-muted mb-4">Silakan buat periode bulanan terlebih dahulu untuk memulai pengisian data operasional.</p>
            <a href="{{ route('periode.create') }}" class="btn btn-coral">
                <i class="bi bi-calendar-plus me-1"></i> Buat Periode Sekarang
            </a>
        </div>
    @else
        <!-- Information Box -->
        <div class="card-custom p-3 bg-white d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill text-danger fs-5"></i>
                <span class="text-dark">Periode Aktif: <strong>{{ $periode->nama_periode }}</strong></span>
                <span class="badge {{ $periode->status === 'divalidasi' ? 'badge-mint-pill' : 'badge-coral-pill' }}">
                    {{ strtoupper($periode->status) }}
                </span>
            </div>
            <div>
                <a href="{{ route('perhitungan.index', ['periode_id' => $periode->id]) }}" class="btn btn-sm btn-coral-outline">
                    <i class="bi bi-calculator me-1"></i> Lihat Langkah Perhitungan SAW
                </a>
            </div>
        </div>

        <!-- Matrix Form -->
        <form action="{{ route('penilaian.store', $periode) }}" method="POST">
            @csrf

            <div class="card-custom overflow-hidden bg-white">
                <div class="p-3 border-bottom border-light d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0">Tabel Nilai Alternatif per Kriteria (Matriks Keputusan X)</h6>
                    <small class="text-muted">Nilai akan dinormalisasi otomatis sesuai rumus Benefit/Cost</small>
                </div>

                <div class="table-responsive">
                    <table class="table-modern text-nowrap">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" class="align-middle" style="width: 60px;">Kode</th>
                                <th rowspan="2" class="align-middle text-start">Alternatif (Varian Roti)</th>
                                @foreach ($kriterias as $k)
                                    <th>
                                        <div class="fw-bold text-dark">{{ $k->kode }}</div>
                                        <div class="small fw-semibold text-secondary" style="font-size: 0.8rem;">{{ $k->nama }}</div>
                                        <span class="badge {{ $k->sifat === 'benefit' ? 'badge-mint-pill' : 'badge-coral-pill' }}" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">
                                            {{ strtoupper($k->sifat) }} ({{ round($k->bobot * 100) }}%)
                                        </span>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="text-center" style="font-size: 0.75rem; background-color: #FAFAFB;">
                                @foreach ($kriterias as $k)
                                    <th class="text-muted">{{ $k->satuan ?? 'Nilai' }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($varians as $v)
                                <tr>
                                    <td class="text-center fw-bold">
                                        <span class="badge badge-gray-pill">{{ $v->kode }}</span>
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
                    <div class="p-3 border-top border-light d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle text-danger"></i> Menyimpan data akan otomatis memproses normalisasi matriks dan skor preferensi SAW.
                        </small>
                        <button type="submit" class="btn btn-coral">
                            <i class="bi bi-save me-1"></i> Simpan & Jalankan SAW Otomatis
                        </button>
                    </div>
                @endcan
            </div>
        </form>
    @endif
</div>
@endsection
