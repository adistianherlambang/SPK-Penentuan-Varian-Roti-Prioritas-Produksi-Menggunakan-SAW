@extends('layouts.app')

@section('title', 'Perhitungan Algoritma SAW')

@section('content')
<div class="mb-4">
    <!-- Filter Periode & Action Header -->
    <div class="card-custom p-3 mb-4">
        <div class="row align-items-center g-3">
            <div class="col-md-7">
                <h4 class="fw-bold text-dark mb-1">Perhitungan Simple Additive Weighting (SAW)</h4>
                <p class="text-muted small mb-0">Tahapan transparansi normalisasi matriks dan pembobotan preferensi prioritas produksi</p>
            </div>
            <div class="col-md-5">
                <form action="{{ route('perhitungan.index') }}" method="GET" class="d-flex align-items-center gap-2">
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

    @if (!$hasilSaw || !$hasilSaw['status'])
        <div class="alert alert-warning border-0 p-4 text-center">
            <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
            <strong>Data Belum Lengkap untuk Dihitung</strong>
            <p class="small text-muted mb-3">{{ $hasilSaw['message'] ?? 'Silakan pastikan kriteria, varian roti, dan data operasional telah diisi.' }}</p>
            <a href="{{ route('penilaian.index', ['periode_id' => $periode?->id]) }}" class="btn btn-amber btn-sm">
                <i class="bi bi-pencil-square"></i> Lengkapi Data Penilaian
            </a>
        </div>
    @else
        <!-- Action Buttons & Status -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-dark px-3 py-2">
                    {{ $periode->nama_periode }}
                </span>
                <span class="badge {{ $periode->status === 'divalidasi' ? 'bg-success' : 'bg-primary' }} px-3 py-2">
                    Status: {{ strtoupper($periode->status) }}
                </span>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('perhitungan.hitung-ulang', $periode) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-arrow-clockwise"></i> Hitung Ulang & Simpan
                    </button>
                </form>
                <a href="{{ route('laporan.cetak', $periode) }}" target="_blank" class="btn btn-sm btn-amber">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <!-- 4 Step Tabs of SAW -->
        <div class="card-custom overflow-hidden mb-4">
            <div class="border-bottom bg-light px-3 pt-3">
                <ul class="nav nav-tabs border-bottom-0" id="sawTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="ranking-tab" data-bs-toggle="tab" data-bs-target="#ranking" type="button" role="tab">
                            <i class="bi bi-trophy-fill text-warning me-1"></i> 1. Hasil Perangkingan (Vᵢ)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="matriks-r-tab" data-bs-toggle="tab" data-bs-target="#matriks-r" type="button" role="tab">
                            <i class="bi bi-sliders text-primary me-1"></i> 2. Matriks Normalisasi (R)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="kriteria-stat-tab" data-bs-toggle="tab" data-bs-target="#kriteria-stat" type="button" role="tab">
                            <i class="bi bi-bar-chart-steps text-info me-1"></i> 3. Min/Max & Bobot Kriteria
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="matriks-x-tab" data-bs-toggle="tab" data-bs-target="#matriks-x" type="button" role="tab">
                            <i class="bi bi-table text-secondary me-1"></i> 4. Matriks Keputusan (X)
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content p-4" id="sawTabsContent">
                <!-- TAB 1: HASIL PERANGKINGAN & REKOMENDASI -->
                <div class="tab-pane fade show active" id="ranking" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Rekomendasi Prioritas Produksi Varian Roti</h5>
                            <small class="text-muted">Hasil akhir penjumlahan terbobot: <code>Vᵢ = ∑ (Wⱼ × Rᵢⱼ)</code></small>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70px;" class="text-center">Peringkat</th>
                                    <th style="width: 80px;" class="text-center">Kode</th>
                                    <th>Nama Varian Roti</th>
                                    <th class="text-center">Nilai Preferensi (Vᵢ)</th>
                                    <th>Klasifikasi Rekomendasi</th>
                                    <th>Arahan Kebijakan Produksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['hasil_perankingan'] as $item)
                                    <tr>
                                        <td class="text-center">
                                            @if($item['ranking'] == 1)
                                                <span class="badge rounded-circle bg-warning text-dark fs-6" style="width: 32px; height: 32px; line-height: 22px;">1</span>
                                            @elseif($item['ranking'] == 2)
                                                <span class="badge rounded-circle bg-secondary text-white fs-6" style="width: 32px; height: 32px; line-height: 22px;">2</span>
                                            @elseif($item['ranking'] == 3)
                                                <span class="badge rounded-circle bg-dark text-white fs-6" style="width: 32px; height: 32px; line-height: 22px;">3</span>
                                            @else
                                                <span class="badge rounded-circle bg-light text-dark border fs-6" style="width: 32px; height: 32px; line-height: 22px;">{{ $item['ranking'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center fw-bold">
                                            <span class="badge bg-secondary">{{ $item['varian']->kode }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $item['varian']->nama_varian }}</div>
                                            <small class="text-muted">{{ $item['varian']->kategori }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary fs-6">{{ $item['nilai_preferensi'] }}</span>
                                        </td>
                                        <td>
                                            @if($item['rekomendasi'] === 'Prioritas Utama')
                                                <span class="badge badge-priority-utama px-3 py-1 fs-6">
                                                    <i class="bi bi-star-fill text-warning me-1"></i> Prioritas Utama
                                                </span>
                                            @elseif($item['rekomendasi'] === 'Prioritas Sedang')
                                                <span class="badge badge-priority-sedang px-3 py-1 fs-6">
                                                    <i class="bi bi-dash-circle me-1"></i> Prioritas Sedang
                                                </span>
                                            @else
                                                <span class="badge badge-priority-rendah px-3 py-1 fs-6">
                                                    <i class="bi bi-arrow-down-circle me-1"></i> Prioritas Rendah
                                                </span>
                                            @endif
                                        </td>
                                        <td class="small text-muted" style="max-width: 300px;">
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
                    <div class="alert alert-light border d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-info-circle text-primary fs-5"></i>
                        <small class="text-muted">
                            Rumus Normalisasi Matriks: <br>
                            • Atribut <strong>Benefit</strong>: <code>Rᵢⱼ = Xᵢⱼ / Max(Xⱼ)</code> &nbsp;|&nbsp;
                            • Atribut <strong>Cost</strong>: <code>Rᵢⱼ = Min(Xⱼ) / Xᵢⱼ</code>
                        </small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;">Kode</th>
                                    <th class="text-start">Alternatif</th>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <th>
                                            <div>{{ $k->kode }}</div>
                                            <small class="badge {{ $k->sifat === 'benefit' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $k->sifat === 'benefit' ? 'text-success' : 'text-danger' }}">
                                                {{ strtoupper($k->sifat) }}
                                            </small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilSaw['varians'] as $v)
                                    <tr>
                                        <td class="fw-bold bg-light"><span class="badge bg-secondary">{{ $v->kode }}</span></td>
                                        <td class="text-start fw-semibold text-dark">{{ $v->nama_varian }}</td>
                                        @foreach ($hasilSaw['kriterias'] as $k)
                                            @php
                                                $rVal = $hasilSaw['matrix_r'][$v->id][$k->id] ?? 0;
                                            @endphp
                                            <td class="fw-bold text-primary">{{ $rVal }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: NILAI MIN / MAX & BOBOT -->
                <div class="tab-pane fade" id="kriteria-stat" role="tabpanel">
                    <h6 class="fw-bold text-dark mb-3">Nilai Ekstrem Kriteria (Pembagi Normalisasi) & Bobot W</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-light">
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
                                    <td class="fw-bold text-start bg-light">Sifat Atribut</td>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <td>
                                            <span class="badge {{ $k->sifat === 'benefit' ? 'bg-success' : 'bg-danger' }}">
                                                {{ strtoupper($k->sifat) }}
                                            </span>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start bg-light">Bobot Relatif (W)</td>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <td class="fw-bold">{{ $k->bobot }} ({{ round($k->bobot * 100) }}%)</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start bg-light">Nilai Maksimum (Max Xⱼ)</td>
                                    @foreach ($hasilSaw['kriterias'] as $k)
                                        <td class="fw-bold text-success">{{ $hasilSaw['kriteria_stats'][$k->id]['max'] }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-start bg-light">Nilai Minimum (Min Xⱼ)</td>
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
                    <h6 class="fw-bold text-dark mb-3">Matriks Keputusan Awal (X)</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-light">
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
                                        <td class="fw-bold bg-light"><span class="badge bg-secondary">{{ $v->kode }}</span></td>
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
