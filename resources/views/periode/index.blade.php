@extends('layouts.app')

@section('title', 'Periode Produksi Bulanan')

@section('content')
<div class="d-flex flex-column gap-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Periode Penilaian Produksi</h4>
            <p class="text-muted small mb-0">Manajemen periode bulanan untuk penentuan prioritas produksi varian roti</p>
        </div>
        @can('manage-data')
            <a href="{{ route('periode.create') }}" class="btn btn-coral">
                <i class="bi bi-calendar-plus me-1"></i> Buat Periode Baru
            </a>
        @endcan
    </div>

    <div class="card-custom overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Nama Periode</th>
                        <th>Bulan & Tahun</th>
                        <th class="text-center">Data Operasional</th>
                        <th class="text-center">Status Proses</th>
                        <th>Catatan Validasi Manajemen</th>
                        <th style="width: 220px;" class="text-center">Aksi & Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($periodes as $p)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->nama_periode }}</div>
                                <small class="text-muted">Dibuat: {{ $p->created_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <span class="badge badge-gray-pill">
                                    {{ DateTime::createFromFormat('!m', $p->bulan)->format('F') }} {{ $p->tahun }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($p->penilaians_count > 0)
                                    <span class="badge badge-mint-pill">
                                        <i class="bi bi-check-circle me-1"></i> Terisi ({{ $p->penilaians_count }} sel)
                                    </span>
                                @else
                                    <span class="badge badge-gray-pill">
                                        <i class="bi bi-clock me-1"></i> Belum Diisi
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->status === 'divalidasi')
                                    <span class="badge badge-mint-pill px-3 py-1">
                                        <i class="bi bi-shield-check me-1"></i> Divalidasi
                                    </span>
                                @elseif($p->status === 'dihitung')
                                    <span class="badge badge-coral-pill px-3 py-1">
                                        <i class="bi bi-calculator me-1"></i> Dihitung
                                    </span>
                                @else
                                    <span class="badge badge-gray-pill px-3 py-1">
                                        <i class="bi bi-pencil me-1"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="small text-muted" style="max-width: 260px;">
                                @if($p->catatan_manajemen)
                                    <div class="fst-italic text-dark">"{{ $p->catatan_manajemen }}"</div>
                                    <small class="text-success fw-semibold">
                                        <i class="bi bi-check-circle-fill"></i> Validasi: {{ $p->tanggal_validasi?->format('d/m/Y H:i') }}
                                    </small>
                                @else
                                    <span class="text-muted">- Menunggu evaluasi -</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('penilaian.index', ['periode_id' => $p->id]) }}" class="btn btn-sm btn-coral-outline" title="Input Data Penilaian">
                                        <i class="bi bi-table"></i> Input
                                    </a>
                                    <a href="{{ route('perhitungan.index', ['periode_id' => $p->id]) }}" class="btn btn-sm btn-pill-light" title="Lihat Kalkulasi SAW">
                                        <i class="bi bi-calculator"></i> SAW
                                    </a>
                                    
                                    @can('manajemen')
                                        @if($p->status !== 'divalidasi' && $p->hasil_saw_details_count > 0)
                                            <button type="button" class="btn btn-sm btn-coral" data-bs-toggle="modal" data-bs-target="#validasiModal{{ $p->id }}" title="Validasi Hasil Produksi">
                                                <i class="bi bi-check2-circle"></i> Validasi
                                            </button>
                                        @endif
                                    @endcan

                                    @can('manage-data')
                                        <form action="{{ route('periode.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus periode ini beserta seluruh data penilaiannya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-pill-light text-danger" title="Hapus Periode">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>

                                <!-- Modal Validasi untuk Manajemen -->
                                <div class="modal fade text-start" id="validasiModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form action="{{ route('periode.validasi', $p) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-bottom border-light p-4">
                                                    <h5 class="modal-title fw-bold text-dark">Validasi Keputusan Produksi Bulanan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <p class="small text-muted mb-3">
                                                        Sebagai pihak <strong>Manajemen (Bapak Wisnu Nur Yadi)</strong>, Anda akan menyetujui rekomendasi urutan prioritas produksi untuk <strong>{{ $p->nama_periode }}</strong>.
                                                    </p>
                                                    <div class="mb-3">
                                                        <label for="catatan_manajemen" class="form-label fw-semibold text-dark">Catatan / Arahan Manajemen:</label>
                                                        <textarea class="form-control" name="catatan_manajemen" rows="3" placeholder="Contoh: Disetujui untuk diproduksi sesuai rekomendasi peringkat SAW. Pastikan ketersediaan kemasan Roti Coklat Lumer aman."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top border-light p-3">
                                                    <button type="button" class="btn btn-pill-light" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-coral">
                                                        <i class="bi bi-shield-check me-1"></i> Sahkan & Validasi
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada periode penilaian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
