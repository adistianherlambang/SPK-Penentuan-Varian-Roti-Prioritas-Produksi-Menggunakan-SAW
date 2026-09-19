@extends('layouts.app')

@section('title', 'Varian Roti')

@section('content')
<div class="d-flex flex-column gap-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Varian Roti</h4>
            <p class="text-muted small mb-0">Daftar alternatif produksi</p>
        </div>
        @can('manage-data')
            <a href="{{ route('varian.create') }}" class="btn btn-coral">
                <i class="bi bi-plus-circle me-1"></i> Tambah Varian
            </a>
        @endcan
    </div>

    <div class="card-custom overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 80px;" class="text-center">Kode</th>
                        <th>Nama Varian</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Margin</th>
                        <th>Deskripsi</th>
                        @can('manage-data')
                            <th style="width: 100px;" class="text-center">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($varians as $v)
                        <tr>
                            <td class="text-center">
                                <span class="badge badge-gray-pill px-2 py-1">{{ $v->kode }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $v->nama_varian }}</div>
                            </td>
                            <td>
                                <span class="badge badge-coral-pill">{{ $v->kategori }}</span>
                            </td>
                            <td class="text-end fw-semibold text-secondary">
                                Rp {{ number_format($v->harga_jual, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($v->estimasi_keuntungan, 0, ',', '.') }}
                            </td>
                            <td class="small text-muted" style="max-width: 250px;">
                                {{ $v->deskripsi ?? '-' }}
                            </td>
                            @can('manage-data')
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('varian.edit', $v) }}" class="btn btn-sm btn-coral-outline" title="Ubah">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('varian.destroy', $v) }}" method="POST" onsubmit="return confirm('Hapus varian roti ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-pill-light text-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data varian roti.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
