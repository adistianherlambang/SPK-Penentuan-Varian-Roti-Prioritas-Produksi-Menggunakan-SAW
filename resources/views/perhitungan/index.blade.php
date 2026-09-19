@extends('layouts.app')

@section('title', 'Perhitungan SAW')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Filter Periode & Action Header -->
    <div class="card-custom p-4 bg-white">
        <div class="row align-items-center g-3">
            <div class="col-md-7">
                <h4 class="fw-bold text-dark mb-1">Perhitungan SAW</h4>
                <p class="text-muted small mb-0">Normalisasi matriks dan pembobotan preferensi</p>
            </div>
            <div class="col-md-5">
                <form action="{{ route('perhitungan.index') }}" method="GET" class="d-flex align-items-center justify-content-md-end gap-2">
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

    @if (!$hasilSaw || !$hasilSaw['status'])
        <div class="card-custom p-5 bg-white text-center">
            <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="background-color: #FEF2F2; color: #EF4444; width: 56px; height: 56px;">
                <i class="bi bi-exclamation-triangle fs-3"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Data Belum Lengkap</h5>
            <p class="small text-muted mb-4">{{ $hasilSaw['message'] ?? 'Pastikan kriteria, varian, dan penilaian telah diisi.' }}</p>
            <a href="{{ route('penilaian.index', ['periode_id' => $periode?->id]) }}" class="btn btn-coral">
                Isi Penilaian
            </a>
        </div>
    @else
        <!-- Action Buttons & Status -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-gray-pill px-3 py-2">
                    {{ $periode->nama_periode }}
                </span>
                <span class="badge {{ $periode->status === 'divalidasi' ? 'badge-mint-pill' : 'badge-coral-pill' }} px-3 py-2">
                    {{ strtoupper($periode->status) }}
                </span>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('perhitungan.hitung-ulang', $periode) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-coral-outline">
                        <i class="bi bi-arrow-clockwise me-1"></i> Hitung Ulang
                    </button>
                </form>
                <a href="{{ route('laporan.cetak', $periode) }}" target="_blank" class="btn btn-sm btn-coral">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <!-- 4 Step Tabs of SAW -->
        <div class="card-custom overflow-hidden bg-white mb-4">
            <div class="border-bottom border-light px-4 pt-3 bg-light">
                <ul class="nav nav-pills gap-2 pb-3" id="sawTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-coral active" id="ranking-tab" data-bs-toggle="pill" data-bs-target="#ranking" type="button" role="tab">
                            1. Perangkingan (Vi)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-pill-light" id="matriks-r-tab" data-bs-toggle="pill" data-bs-target="#matriks-r" type="button" role="tab">
                            2. Matriks R
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-pill-light" id="kriteria-stat-tab" data-bs-toggle="pill" data-bs-target="#kriteria-stat" type="button" role="tab">
                            3. Kriteria & Bobot
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-sm btn-pill-light" id="matriks-x-tab" data-bs-toggle="pill" data-bs-target="#matriks-x" type="button" role="tab">
                            4. Matriks X
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
                                    <th style="width: 70px;" class="text-center">Rank</th>
                                    <th style="width: 80px;" class="text-center">Kode</th>
                                    <th>Nama Varian</th>
                                    <th class="text-center">Skor (Vi)</th>
                                    <th>Klasifikasi</th>
                                    <th>Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['hasil_perankingan'] as $item)
                                    <tr>
                                        <td class="text-center">
                                            @if($item['ranking'] == 1)
                                                <span class="badge rounded-circle bg-danger text-white fs-6" style="width: 30px; height: 30px; line-height: 20px;">1</span>
                                            @elseif($item['ranking'] == 2)
                                                <span class="badge rounded-circle bg-secondary text-white fs-6" style="width: 30px; height: 30px; line-height: 20px;">2</span>
                                            @elseif($item['ranking'] == 3)
                                                <span class="badge rounded-circle bg-dark text-white fs-6" style="width: 30px; height: 30px; line-height: 20px;">3</span>
                                            @else
                                                <span class="badge rounded-circle bg-light text-dark border fs-6" style="width: 30px; height: 30px; line-height: 20px;">{{ $item['ranking'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center fw-bold">
                                            <span class="badge badge-gray-pill">{{ $item['varian']->kode }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $item['varian']->nama_varian }}</div>
                                            <small class="text-muted">{{ $item['varian']->kategori }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-danger fs-5">{{ $item['nilai_preferensi'] }}</span>
                                        </td>
                                        <td>
                                            @if($item['rekomendasi'] === 'Prioritas Utama')
                                                <span class="badge badge-mint-pill px-3 py-1">
                                                    Prioritas Utama
                                                </span>
                                            @elseif($item['rekomendasi'] === 'Prioritas Sedang')
                                                <span class="badge badge-coral-pill px-3 py-1">
                                                    Prioritas Sedang
                                                </span>
                                            @else
                                                <span class="badge badge-gray-pill px-3 py-1">
                                                    Prioritas Rendah
                                                </span>
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
                                    <th style="width: 80px;">Kode</th>
                                    <th class="text-start">Alternatif</th>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <th>
                                            <div>{{ $k->kode }}</div>
                                            <span class="badge {{ $k->sifat === 'benefit' ? 'badge-mint-pill' : 'badge-coral-pill' }}" style="font-size: 0.65rem;">
                                                {{ strtoupper($k->sifat) }}
                                            </span>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['varians'] as $v)
                                    <tr>
                                        <td class="fw-bold"><span class="badge badge-gray-pill">{{ $v->kode }}</span></td>
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
                                        <td>
                                            <span class="badge {{ $k->sifat === 'benefit' ? 'badge-mint-pill' : 'badge-coral-pill' }}">
                                                {{ strtoupper($k->sifat) }}
                                            </span>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start">Bobot (W)</td>
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
                                    <th style="width: 80px;">Kode</th>
                                    <th class="text-start">Alternatif</th>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <th>
                                            <div>{{ $k->kode }}</div>
                                            <small class="text-muted">({{ $k->satuan ?? 'Nilai' }})</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['varians'] as $v)
                                    <tr>
                                        <td class="fw-bold"><span class="badge badge-gray-pill">{{ $v->kode }}</span></td>
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
