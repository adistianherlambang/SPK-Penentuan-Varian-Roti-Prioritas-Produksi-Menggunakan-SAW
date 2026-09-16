@extends('layouts.app')

@section('title', 'Laporan Rekomendasi Produksi')

@section('content')
<div class="mb-4">
    <!-- Filter Header -->
    <div class="card-custom p-3 mb-4">
        <div class="row align-items-center g-3">
            <div class="col-md-7">
                <h4 class="fw-bold text-dark mb-1">Laporan Rekomendasi Prioritas Produksi</h4>
                <p class="text-muted small mb-0">Hasil evaluasi bulanan untuk acuan pengambilan keputusan bagian operasional dan manajemen</p>
            </div>
            <div class="col-md-5">
                <form action="{{ route('laporan.index') }}" method="GET" class="d-flex align-items-center gap-2">
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

    @if(!$periode || $hasilSaw->isEmpty())
        <div class="alert alert-warning border-0 p-4 text-center">
            <i class="bi bi-file-earmark-x fs-3 d-block mb-2"></i>
            <strong>Belum ada laporan untuk periode ini.</strong>
            <p class="small text-muted mb-0">Pastikan data operasional telah diinput dan proses perhitungan SAW telah dieksekusi.</p>
        </div>
    @else
        <div class="card-custom p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Laporan Evaluasi: {{ $periode->nama_periode }}</h5>
                    <div class="small text-muted">
                        Status Validasi: 
                        @if($periode->status === 'divalidasi')
                            <span class="badge bg-success"><i class="bi bi-shield-check"></i> Telah Disetujui Manajemen</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> Belum Divalidasi Manajemen</span>
                        @endif
                    </div>
                </div>
                <div>
                    <a href="{{ route('laporan.cetak', $periode) }}" target="_blank" class="btn btn-amber shadow-sm">
                        <i class="bi bi-printer me-1"></i> Cetak / Unduh Dokumen Resmi (PDF)
                    </a>
                </div>
            </div>

            <!-- Management Notes Display -->
            @if($periode->catatan_manajemen)
                <div class="alert alert-success border-0 bg-success bg-opacity-10 mb-4">
                    <div class="fw-semibold text-dark mb-1"><i class="bi bi-chat-left-quote-fill text-success me-1"></i> Catatan & Arahan Manajemen (Bapak Wisnu Nur Yadi):</div>
                    <div class="fst-italic text-muted">"{{ $periode->catatan_manajemen }}"</div>
                    <small class="text-muted d-block mt-1">Divalidasi pada: {{ $periode->tanggal_validasi?->format('d F Y, H:i') }} WIB</small>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th style="width: 70px;">Peringkat</th>
                            <th style="width: 80px;">Kode</th>
                            <th class="text-start">Nama Varian Roti</th>
                            <th style="width: 130px;">Skor Preferensi (Vᵢ)</th>
                            <th style="width: 170px;">Status Prioritas</th>
                            <th class="text-start">Rekomendasi Kebijakan Produksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilSaw as $item)
                            <tr>
                                <td class="text-center fw-bold">
                                    @if($item->ranking == 1)
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">#1</span>
                                    @elseif($item->ranking == 2)
                                        <span class="badge rounded-pill bg-secondary text-white px-3 py-2">#2</span>
                                    @elseif($item->ranking == 3)
                                        <span class="badge rounded-pill bg-dark text-white px-3 py-2">#3</span>
                                    @else
                                        <span class="text-muted">#{{ $item->ranking }}</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold bg-light">
                                    <span class="badge bg-secondary">{{ $item->varianRoti->kode }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->varianRoti->nama_varian }}</div>
                                    <small class="text-muted">{{ $item->varianRoti->kategori }} • Harga: Rp {{ number_format($item->varianRoti->harga_jual, 0, ',', '.') }}</small>
                                </td>
                                <td class="text-center fw-bold text-primary fs-6">
                                    {{ $item->nilai_preferensi }}
                                </td>
                                <td class="text-center">
                                    @if($item->rekomendasi === 'Prioritas Utama')
                                        <span class="badge badge-priority-utama px-3 py-1">Prioritas Utama</span>
                                    @elseif($item->rekomendasi === 'Prioritas Sedang')
                                        <span class="badge badge-priority-sedang px-3 py-1">Prioritas Sedang</span>
                                    @else
                                        <span class="badge badge-priority-rendah px-3 py-1">Prioritas Rendah</span>
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
