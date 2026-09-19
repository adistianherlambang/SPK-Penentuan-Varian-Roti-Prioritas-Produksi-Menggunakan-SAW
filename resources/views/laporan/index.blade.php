@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="d-flex flex-column gap-3">
    <!-- Filter & Aksi -->
    <div class="card-custom p-3 px-4 bg-white">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('laporan.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    <select name="periode_id" id="periode_id" class="select-pill" onchange="this.form.submit()">
                        @foreach ($periodes as $p)
                            <option value="{{ $p->id }}" {{ ($periode && $periode->id == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                </form>
                @if($periode)
                    <span class="badge {{ $periode->status === 'divalidasi' ? 'badge-mint-pill' : 'badge-coral-pill' }}">
                        {{ ucfirst($periode->status) }}
                    </span>
                @endif
            </div>

            @if($periode && $hasilSaw->isNotEmpty())
                <a href="{{ route('laporan.cetak', $periode) }}" target="_blank" class="btn btn-sm btn-coral">
                    <i class="bi bi-printer me-1"></i> Cetak PDF
                </a>
            @endif
        </div>
    </div>

    @if(!$periode || $hasilSaw->isEmpty())
        <div class="card-custom p-5 bg-white text-center">
            <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="background-color: #FEF2F2; color: #EF4444; width: 56px; height: 56px;">
                <i class="bi bi-file-earmark-x fs-3"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Belum ada laporan</h6>
            <p class="small text-muted mb-0">Selesaikan penilaian dan perhitungan terlebih dahulu.</p>
        </div>
    @else
        <div class="card-custom p-4 bg-white">
            <!-- Catatan Manajemen -->
            @if($periode->catatan_manajemen)
                <div class="p-3 rounded-3 mb-3" style="background-color: #F0FDF4; border-left: 3px solid var(--mint-500);">
                    <div class="small fw-semibold text-success mb-1">Catatan:</div>
                    <div class="small text-dark">"{{ $periode->catatan_manajemen }}"</div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 50px;">#</th>
                            <th style="width: 70px;">Kode</th>
                            <th class="text-start">Varian</th>
                            <th style="width: 120px;">Skor</th>
                            <th style="width: 140px;">Prioritas</th>
                            <th class="text-start">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilSaw as $item)
                            <tr>
                                <td class="text-center">
                                    <span class="badge rounded-circle {{ $item->ranking == 1 ? 'bg-danger text-white' : ($item->ranking <= 3 ? 'bg-danger-subtle text-danger' : 'bg-light text-muted border') }} fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                        {{ $item->ranking }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-gray-pill">{{ $item->varianRoti->kode }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->varianRoti->nama_varian }}</div>
                                    <small class="text-muted">{{ $item->varianRoti->kategori }} • Rp {{ number_format($item->varianRoti->harga_jual, 0, ',', '.') }}</small>
                                </td>
                                <td class="text-center fw-bold text-danger">
                                    {{ $item->nilai_preferensi }}
                                </td>
                                <td class="text-center">
                                    @if($item->rekomendasi === 'Prioritas Utama')
                                        <span class="badge badge-priority-utama">Utama</span>
                                    @elseif($item->rekomendasi === 'Prioritas Sedang')
                                        <span class="badge badge-priority-sedang">Sedang</span>
                                    @else
                                        <span class="badge badge-priority-rendah">Rendah</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $item->catatan }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
