@extends('layouts.app')

@section('title', 'Kriteria')

@section('content')
<div class="d-flex flex-column gap-3">
    <div class="d-flex justify-content-between align-items-center">
        <span class="fw-semibold small text-muted">
            Total Bobot: {{ round($totalBobot * 100) }}%
        </span>
    </div>

    <div class="card-custom overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">Kode</th>
                        <th>Kriteria</th>
                        <th class="text-center">Sifat</th>
                        <th class="text-center">Bobot</th>
                        <th class="text-center">%</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        @can('manage-data')
                            <th style="width: 80px;" class="text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kriterias as $k)
                        <tr>
                            <td class="text-center">
                                <span class="fw-bold text-dark">{{ $k->kode }}</span>
                            </td>
                            <td class="fw-bold text-dark">{{ $k->nama }}</td>
                            <td class="text-center">
                                @if($k->sifat === 'benefit')
                                    <span class="text-success fw-semibold small">Benefit</span>
                                @else
                                    <span class="text-danger fw-semibold small">Cost</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-danger">{{ $k->bobot }}</td>
                            <td class="text-center fw-semibold">{{ round($k->bobot * 100) }}%</td>
                            <td><span class="text-muted small">{{ $k->satuan ?? '-' }}</span></td>
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
                            <td colspan="8" class="text-center text-muted py-4">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
