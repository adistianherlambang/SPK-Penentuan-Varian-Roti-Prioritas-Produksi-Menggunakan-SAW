@extends('layouts.app')

@section('title', 'Perhitungan SAW')

@section('content')
<div class="d-flex flex-column gap-3">
    <!-- Filter & Aksi -->
    <div class="card-custom p-3 px-4 bg-white">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('perhitungan.index') }}" method="GET" class="d-flex align-items-center gap-2">
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

            @if ($hasilSaw && $hasilSaw['status'] && $periode)
                <div class="d-flex gap-2">
                    <form action="{{ route('perhitungan.hitung-ulang', $periode) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-coral-outline">
                            <i class="bi bi-arrow-clockwise me-1"></i> Hitung Ulang
                        </button>
                    </form>
                    <a href="{{ route('laporan.cetak', $periode) }}" target="_blank" class="btn btn-sm btn-coral">
                        <i class="bi bi-printer me-1"></i> Cetak
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if (!$hasilSaw || !$hasilSaw['status'])
        <div class="card-custom p-5 bg-white text-center">
            <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="background-color: #FEF2F2; color: #EF4444; width: 56px; height: 56px;">
                <i class="bi bi-exclamation-triangle fs-3"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Data Belum Lengkap</h6>
            <p class="small text-muted mb-3">{{ $hasilSaw['message'] ?? 'Isi data penilaian terlebih dahulu.' }}</p>
            <a href="{{ route('penilaian.index', ['periode_id' => $periode?->id]) }}" class="btn btn-sm btn-coral">
                Input Penilaian
            </a>
        </div>
    @else
        <!-- 4 Step Tabs of SAW -->
        <div class="card-custom overflow-hidden bg-white">
            <div class="border-bottom border-light px-4 pt-3 bg-light">
                <ul class="nav nav-pills gap-2 pb-3" id="sawTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-coral active" id="ranking-tab" data-bs-toggle="pill" data-bs-target="#ranking" type="button" role="tab">
                            Perangkingan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-pill-light" id="matriks-r-tab" data-bs-toggle="pill" data-bs-target="#matriks-r" type="button" role="tab">
                            Normalisasi (R)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-pill-light" id="kriteria-stat-tab" data-bs-toggle="pill" data-bs-target="#kriteria-stat" type="button" role="tab">
                            Bobot (W)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-pill-light" id="matriks-x-tab" data-bs-toggle="pill" data-bs-target="#matriks-x" type="button" role="tab">
                            Matriks (X)
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content p-4" id="sawTabsContent">
                <!-- TAB 1: HASIL PERANGKINGAN -->
                <div class="tab-pane fade show active" id="ranking" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">#</th>
                                    <th style="width: 70px;" class="text-center">Kode</th>
                                    <th>Varian</th>
                                    <th class="text-center">Skor</th>
                                    <th>Prioritas</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['hasil_perankingan'] as $item)
                                    <tr>
                                        <td class="text-center fw-bold {{ $item['ranking'] == 1 ? 'text-danger' : 'text-dark' }}">
                                            #{{ $item['ranking'] }}
                                        </td>
                                        <td class="text-center fw-semibold text-secondary">
                                            {{ $item['varian']->kode }}
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $item['varian']->nama_varian }}</div>
                                            <small class="text-muted">{{ $item['varian']->kategori }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-danger">{{ $item['nilai_preferensi'] }}</span>
                                        </td>
                                        <td>
                                            @if($item['rekomendasi'] === 'Prioritas Utama')
                                                <span class="text-success fw-semibold">Utama</span>
                                            @elseif($item['rekomendasi'] === 'Prioritas Sedang')
                                                <span class="text-warning fw-semibold">Sedang</span>
                                            @else
                                                <span class="text-muted fw-semibold">Rendah</span>
                                            @endif
                                        </td>
                                        <td class="small text-muted" style="max-width: 280px;">
                                            {{ $item['catatan'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 2: MATRIKS TERNORMALISASI (R) -->
                <div class="tab-pane fade" id="matriks-r" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern text-center">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">Kode</th>
                                    <th class="text-start">Alternatif</th>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <th>
                                            <div>{{ $k->kode }}</div>
                                            <div class="fw-medium {{ $k->sifat === 'benefit' ? 'text-success' : 'text-danger' }}" style="font-size: 0.7rem;">
                                                {{ ucfirst($k->sifat) }}
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['varians'] as $v)
                                    <tr>
                                        <td class="fw-semibold text-secondary">{{ $v->kode }}</td>
                                        <td class="text-start fw-semibold text-dark">{{ $v->nama_varian }}</td>
                                        @foreach ($hasilSaw['kriterias'] as $k)
                                            @php
                                                $rVal = $hasilSaw['matrix_r'][$v->id][$k->id] ?? 0;
                                            @endphp
                                            <td class="fw-bold text-danger">{{ $rVal }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: NILAI MIN / MAX & BOBOT -->
                <div class="tab-pane fade" id="kriteria-stat" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern text-center">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <th>
                                            <div>{{ $k->kode }}</div>
                                            <small class="text-muted">{{ $k->nama }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-start">Sifat</td>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <td class="fw-semibold {{ $k->sifat === 'benefit' ? 'text-success' : 'text-danger' }}">
                                            {{ ucfirst($k->sifat) }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Bobot</td>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <td class="fw-bold">{{ $k->bobot }} ({{ round($k->bobot * 100) }}%)</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Max Xj</td>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <td class="fw-bold text-success">{{ $hasilSaw['kriteria_stats'][$k->id]['max'] }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Min Xj</td>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <td class="fw-bold text-danger">{{ $hasilSaw['kriteria_stats'][$k->id]['min'] }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 4: MATRIKS KEPUTUSAN (X) -->
                <div class="tab-pane fade" id="matriks-x" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern text-center">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">Kode</th>
                                    <th class="text-start">Alternatif</th>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <th>
                                            <div>{{ $k->kode }}</div>
                                            <small class="text-muted">({{ $k->satuan ?? '-' }})</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['varians'] as $v)
                                    <tr>
                                        <td class="fw-semibold text-secondary">{{ $v->kode }}</td>
                                        <td class="text-start fw-semibold text-dark">{{ $v->nama_varian }}</td>
                                        @foreach ($hasilSaw['kriterias'] as $k)
                                            <td class="fw-semibold">{{ number_format($hasilSaw['matrix_x'][$v->id][$k->id] ?? 0, 0, ',', '.') }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('#sawTabs button').forEach(button => {
        button.addEventListener('shown.bs.tab', (e) => {
            document.querySelectorAll('#sawTabs button').forEach(b => {
                b.classList.remove('btn-coral', 'active');
                b.classList.add('btn-pill-light');
            });
            e.target.classList.remove('btn-pill-light');
            e.target.classList.add('btn-coral', 'active');
        });
    });
</script>
@endpush
