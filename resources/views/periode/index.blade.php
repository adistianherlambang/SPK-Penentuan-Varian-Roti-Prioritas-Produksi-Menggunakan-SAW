@extends('layouts.app')

@section('title', 'Periode')

@section('content')
<div class="d-flex flex-column gap-3">
    @can('manage-data')
        <div class="d-flex justify-content-end">
            <a href="{{ route('periode.create') }}" class="btn btn-coral">
                <i class="bi bi-calendar-plus me-1"></i> Tambah Periode
            </a>
        </div>
    @endcan

    <div class="card-custom overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Bulan</th>
                        <th class="text-center">Data</th>
                        <th class="text-center">Status</th>
                        <th>Catatan</th>
                        <th style="width: 180px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($periodes as $p)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->nama_periode }}</div>
                                <small class="text-muted">{{ $p->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <span class="badge badge-gray-pill">
                                    {{ DateTime::createFromFormat('!m', $p->bulan)->format('M') }} {{ $p->tahun }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($p->penilaians_count > 0)
                                    <span class="badge badge-mint-pill">
                                        Terisi ({{ $p->penilaians_count }})
                                    </span>
                                @else
                                    <span class="badge badge-gray-pill">
                                        Kosong
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->status === 'divalidasi')
                                    <span class="badge badge-mint-pill px-3 py-1">Divalidasi</span>
                                @elseif($p->status === 'dihitung')
                                    <span class="badge badge-coral-pill px-3 py-1">Dihitung</span>
                                @else
                                    <span class="badge badge-gray-pill px-3 py-1">Draf</span>
                                @endif
                            </td>
                            <td class="small text-muted" style="max-width: 240px;">
                                @if($p->catatan_manajemen)
                                    <div class="text-dark">"{{ $p->catatan_manajemen }}"</div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('penilaian.index', ['periode_id' => $p->id]) }}" class="btn btn-sm btn-coral-outline" title="Input">
                                        Input
                                    </a>
                                    <a href="{{ route('perhitungan.index', ['periode_id' => $p->id]) }}" class="btn btn-sm btn-pill-light" title="SAW">
                                        SAW
                                    </a>
                                    
                                    @can('manajemen')
                                        @if($p->status !== 'divalidasi' && $p->hasil_saw_details_count > 0)
                                            <button type="button" class="btn btn-sm btn-coral" data-bs-toggle="modal" data-bs-target="#validasiModal{{ $p->id }}">
                                                Validasi
                                            </button>
                                        @endif
                                    @endcan

                                    @can('manage-data')
                                        <form action="{{ route('periode.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus periode ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-pill-light text-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>

                                <!-- Modal Validasi -->
                                <div class="modal fade text-start" id="validasiModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border">
                                            <form action="{{ route('periode.validasi', $p) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-bottom border-light p-3 px-4">
                                                    <h6 class="modal-title fw-bold text-dark">Validasi Periode</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="mb-2">
                                                        <label for="catatan_manajemen" class="form-label fw-semibold text-dark small">Catatan:</label>
                                                        <textarea class="form-control" name="catatan_manajemen" rows="3" placeholder="Catatan validasi..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top border-light p-3">
                                                    <button type="button" class="btn btn-pill-light" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-coral">
                                                        Validasi
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
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
