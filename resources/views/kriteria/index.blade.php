@extends('layouts.app')

@section('title', 'Kriteria & Bobot')

@section('content')
<div class="d-flex flex-column gap-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Kriteria Penilaian</h4>
            <p class="text-muted small mb-0">5 kriteria penentu prioritas produksi</p>
        </div>
        <div>
            <span class="badge {{ abs($totalBobot - 1.0) < 0.001 ? 'badge-mint-pill' : 'badge-coral-pill' }} px-3 py-2">
                Total Bobot: {{ round($totalBobot * 100) }}%
            </span>
        </div>
    </div>

    <div class="card-custom overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 80px;" class="text-center">Kode</th>
                        <th>Nama Kriteria</th>
                        <th class="text-center">Sifat</th>
                        <th class="text-center">Bobot (W)</th>
                        <th class="text-center">Persentase</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        @can('manage-data')
                            <th style="width: 90px;" class="text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kriterias as $k)
                        <tr>
                            <td class="text-center fw-bold">
                                <span class="badge badge-gray-pill px-2 py-1">{{ $k->kode }}</span>
                            </td>
                            <td class="fw-bold text-dark">{{ $k->nama }}</td>
                            <td class="text-center">
                                @if($k->sifat === 'benefit')
                                    <span class="badge badge-mint-pill px-3 py-1">
                                        Benefit
                                    </span>
                                @else
                                    <span class="badge badge-coral-pill px-3 py-1">
                                        Cost
                                    </span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-danger">{{ $k->bobot }}</td>
                            <td class="text-center fw-semibold">{{ round($k->bobot * 100) }}%</td>
                            <td><span class="badge badge-gray-pill">{{ $k->satuan ?? '-' }}</span></td>
                            <td class="small text-muted" style="max-width: 260px;">{{ $k->keterangan }}</td>
                            @can('manage-data')
                                <td class="text-center">
                                    <a href="{{ route('kriteria.edit', $k) }}" class="btn btn-sm btn-coral-outline">
                                        Edit
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
