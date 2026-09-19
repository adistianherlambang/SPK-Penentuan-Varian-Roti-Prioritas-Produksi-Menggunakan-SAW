@extends('layouts.app')

@section('title', 'Laporan Rekomendasi')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Filter Header -->
    <div class="card-custom p-4 bg-white">
        <div class="row align-items-center g-3">
            <div class="col-md-7">
                <h4 class="fw-bold text-dark mb-1">Laporan Rekomendasi</h4>
                <p class="text-muted small mb-0">Prioritas produksi varian roti</p>
            </div>
            <div class="col-md-5">
                <form action="{{ route('laporan.index') }}" method="GET" class="d-flex align-items-center justify-content-md-end gap-2">
                    <label for="periode_id" class="small fw-semibold text-muted text-nowrap">Periode:</label>
                    <select name="periode_id" id="periode_id" class="select-pill" onchange="this.form.submit()">
                        @foreach ($periodes as $p)
                            <option value="{{ $p->id }}" {{ ($periode && $periode->id == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    @if(!$periode || $hasilSaw->isEmpty())
        <div class="card-custom p-5 bg-white text-center">
            <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="background-color: #FEF2F2; color: #EF4444; width: 56px; height: 56px;">
                <i class="bi bi-file-earmark-x fs-3"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Belum ada laporan</h5>
            <p class="small text-muted mb-0">Pastikan data operasional dan perhitungan telah selesai.</p>
        </div>
    @else
        <div class="card-custom p-4 bg-white mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="fw-bold text-dark mb-0">{{ $periode->nama_periode }}</h5>
                    @if($periode->status === 'divalidasi')
                        <span class="badge badge-mint-pill"><i class="bi bi-shield-check"></i> Divalidasi</span>
                    @else
                        <span class="badge badge-coral-pill"><i class="bi bi-clock"></i> Belum Divalidasi</span>
                    @endif
                </div>
                <div>
                    <a href="{{ route('laporan.cetak', $periode) }}" target="_blank" class="btn btn-coral">
                        <i class="bi bi-printer me-1"></i> Cetak Dokumen (PDF)
                    </a>
                </div>
            </div>

            <!-- Catatan Manajemen -->
            @if($periode->catatan_manajemen)
                <div class="card-custom p-3 bg-white border-0 mb-4" style="border-left: 4px solid var(--mint-500) !important; background-color: #F0FDF4 !important;">
                    <div class="fw-bold text-dark mb-1 d-flex align-items-center gap-2 small">
                        <i class="bi bi-chat-left-quote-fill text-success"></i>
                        Catatan Manajemen (Pak Wisnu):
                    </div>
                    <div class="fst-italic text-muted ps-4 small">"{{ $periode->catatan_manajemen }}"</div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 70px;">Rank</th>
                            <th style="width: 80px;">Kode</th>
                            <th class="text-start">Nama Varian</th>
                            <th style="width: 140px;">Skor (Vi)</th>
                            <th style="width: 160px;">Status</th>
                            <th class="text-start">Kebijakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilSaw as $item)
                            <tr>
                                <td class="text-center fw-bold">
                                    @if($item->ranking == 1)
                                        <span class="badge rounded-circle bg-danger text-white fs-6" style="width: 30px; height: 30px; line-height: 20px;">1</span>
                                    @elseif($item->ranking == 2)
                                        <span class="badge rounded-circle bg-secondary text-white fs-6" style="width: 30px; height: 30px; line-height: 20px;">2</span>
                                    @elseif($item->ranking == 3)
                                        <span class="badge rounded-circle bg-dark text-white fs-6" style="width: 30px; height: 30px; line-height: 20px;">3</span>
                                    @else
                                        <span class="badge rounded-circle bg-light text-dark border fs-6" style="width: 30px; height: 30px; line-height: 20px;">{{ $item->ranking }}</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold">
                                    <span class="badge badge-gray-pill">{{ $item->varianRoti->kode }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->varianRoti->nama_varian }}</div>
                                    <small class="text-muted">{{ $item->varianRoti->kategori }} • Rp {{ number_format($item->varianRoti->harga_jual, 0, ',', '.') }}</small>
                                </td>
                                <td class="text-center fw-bold text-danger fs-5">
                                    {{ $item->nilai_preferensi }}
                                </td>
                                <td class="text-center">
                                    @if($item->rekomendasi === 'Prioritas Utama')
                                        <span class="badge badge-mint-pill px-3 py-1">
                                            Prioritas Utama
                                        </span>
                                    @elseif($item->rekomendasi === 'Prioritas Sedang')
                                        <span class="badge badge-coral-pill px-3 py-1">
                                            Prioritas Sedang
                                        </span>
                                    @else
                                        <span class="badge badge-gray-pill px-3 py-1">
                                            Prioritas Rendah
                                        </span>
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
