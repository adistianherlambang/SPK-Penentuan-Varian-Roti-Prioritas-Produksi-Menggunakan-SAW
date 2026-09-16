@extends('layouts.app')

@section('title', 'Kriteria Penilaian SAW')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Kriteria Penilaian SAW</h4>
            <p class="text-muted small mb-0">Daftar 5 Kriteria Penilaian Penentuan Varian Roti Prioritas Produksi (Proposal Hal. 3 & 47)</p>
        </div>
        <div>
            <span class="badge {{ abs($totalBobot - 1.0) < 0.001 ? 'bg-success' : 'bg-danger' }} px-3 py-2 fs-6">
                Total Bobot: {{ round($totalBobot * 100) }}% ({{ $totalBobot }})
            </span>
        </div>
    </div>

    <!-- Alert Info Kriteria Proposal -->
    <div class="alert alert-warning border-0 bg-warning bg-opacity-10 d-flex align-items-start gap-3 mb-4">
        <i class="bi bi-info-circle-fill fs-4 text-warning mt-1" style="color: #d97706 !important;"></i>
        <div>
            <strong class="text-dark">Keterangan Sifat Kriteria:</strong>
            <ul class="mb-0 small text-muted mt-1 ps-3">
                <li><strong>Benefit (Keuntungan):</strong> Nilai semakin besar semakin baik/diinginkan. Rumus normalisasi: <code>Rᵢⱼ = Xᵢⱼ / Max(Xⱼ)</code>.</li>
                <li><strong>Cost (Biaya/Beban):</strong> Nilai semakin kecil semakin baik/diinginkan. Rumus normalisasi: <code>Rᵢⱼ = Min(Xⱼ) / Xᵢⱼ</code>.</li>
            </ul>
        </div>
    </div>

    <div class="card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">Kode</th>
                        <th>Nama Kriteria</th>
                        <th class="text-center">Sifat (Atribut)</th>
                        <th class="text-center">Bobot (W)</th>
                        <th class="text-center">Persentase</th>
                        <th>Satuan Pengukuran</th>
                        <th>Keterangan Operasional</th>
                        @can('manage-data')
                            <th style="width: 90px;" class="text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kriterias as $k)
                        <tr>
                            <td class="text-center fw-bold">
                                <span class="badge bg-dark px-2 py-1">{{ $k->kode }}</span>
                            </td>
                            <td class="fw-semibold text-dark">{{ $k->nama }}</td>
                            <td class="text-center">
                                @if($k->sifat === 'benefit')
                                    <span class="badge bg-success bg-opacity-15 text-success border border-success-subtle px-2 py-1">
                                        <i class="bi bi-graph-up-arrow me-1"></i> Benefit
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-15 text-danger border border-danger-subtle px-2 py-1">
                                        <i class="bi bi-graph-down-arrow me-1"></i> Cost
                                    </span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-primary">{{ $k->bobot }}</td>
                            <td class="text-center fw-semibold">{{ round($k->bobot * 100) }}%</td>
                            <td><span class="badge bg-light text-secondary border">{{ $k->satuan ?? '-' }}</span></td>
                            <td class="small text-muted" style="max-width: 280px;">{{ $k->keterangan }}</td>
                            @can('manage-data')
                                <td class="text-center">
                                    <a href="{{ route('kriteria.edit', $k) }}" class="btn btn-sm btn-outline-warning" title="Ubah Bobot / Sifat">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
