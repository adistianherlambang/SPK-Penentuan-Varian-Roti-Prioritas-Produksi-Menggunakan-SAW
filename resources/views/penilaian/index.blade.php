@extends('layouts.app')

@section('title', 'Data Operasional')

@section('content')
<div class="d-flex flex-column gap-3">
    <!-- Filter Periode -->
    <div class="card-custom p-3 px-4 bg-white">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('penilaian.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    <select name="periode_id" id="periode_id" class="select-pill" onchange="this.form.submit()">
                        @foreach ($periodes as $p)
                            <option value="{{ $p->id }}" {{ ($periode && $periode->id == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                </form>
                @if($periode)
                    <span class="fw-semibold {{ $periode->status === 'divalidasi' ? 'text-success' : 'text-danger' }}">
                        • {{ ucfirst($periode->status) }}
                    </span>
                @endif
            </div>
            @if($periode)
                <a href="{{ route('perhitungan.index', ['periode_id' => $periode->id]) }}" class="btn btn-sm btn-coral-outline">
                    Perhitungan SAW
                </a>
            @endif
        </div>
    </div>

    @if(!$periode)
        <div class="card-custom p-5 bg-white text-center">
            <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="background-color: #FEF2F2; color: #EF4444; width: 56px; height: 56px;">
                <i class="bi bi-calendar-x fs-3"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Periode belum dipilih</h6>
            <a href="{{ route('periode.create') }}" class="btn btn-sm btn-coral mt-2">
                Tambah Periode
            </a>
        </div>
    @else
        <!-- Matrix Form -->
        <form action="{{ route('penilaian.store', $periode) }}" method="POST">
            @csrf

            <div class="card-custom overflow-hidden bg-white">
                <div class="table-responsive">
                    <table class="table-modern text-nowrap">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" class="align-middle" style="width: 60px;">Kode</th>
                                <th rowspan="2" class="align-middle text-start">Alternatif</th>
                                @foreach ($kriterias as $k)
                                    <th>
                                        <div class="fw-bold text-dark">{{ $k->kode }}</div>
                                        <div class="small text-secondary" style="font-size: 0.75rem;">{{ $k->nama }}</div>
                                        <div class="fw-medium {{ $k->sifat === 'benefit' ? 'text-success' : 'text-danger' }}" style="font-size: 0.7rem;">
                                            {{ ucfirst($k->sifat) }} ({{ round($k->bobot * 100) }}%)
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="text-center" style="font-size: 0.75rem; background-color: #FAFAFB;">
                                @foreach ($kriterias as $k)
                                    <th class="text-muted">{{ $k->satuan ?? '-' }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($varians as $v)
                                <tr>
                                    <td class="text-center fw-bold text-dark">
                                        {{ $v->kode }}
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $v->nama_varian }}</div>
                                        <small class="text-muted">{{ $v->kategori }}</small>
                                    </td>
                                    @foreach ($kriterias as $k)
                                        @php
                                            $val = $matrixX[$v->id][$k->id] ?? 0;
                                        @endphp
                                        <td style="min-width: 110px;">
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
                    <div class="p-3 border-top border-light d-flex justify-content-end">
                        <button type="submit" class="btn btn-coral">
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </button>
                    </div>
                @endcan
            </div>
        </form>
    @endif
</div>
@endsection
