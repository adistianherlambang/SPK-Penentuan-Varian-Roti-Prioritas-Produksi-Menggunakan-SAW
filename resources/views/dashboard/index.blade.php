@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <!-- Welcome Header Banner -->
    <div class="card-custom p-4 bg-white border-0 shadow-sm mb-4 position-relative overflow-hidden">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-warning bg-opacity-25 text-warning px-3 py-1 fw-bold" style="color: #b45309 !important;">
                        SISTEM PENDUKUNG KEPUTUSAN SAW
                    </span>
                    @if($periodeTerbaru)
                        <span class="badge bg-light text-secondary border px-3 py-1">
                            {{ $periodeTerbaru->nama_periode }}
                        </span>
                    @endif
                </div>
                <h3 class="fw-bold text-dark mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">
                    Anda masuk sebagai <strong>{{ auth()->user()->jabatan ?? auth()->user()->role }}</strong>. Sistem ini membantu menentukan varian roti prioritas produksi secara objektif dan terukur menggunakan metode <em>Simple Additive Weighting (SAW)</em> pada Pelangi Nusantara Food.
                </p>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <div class="d-inline-flex align-items-center gap-2">
                    <a href="{{ route('perhitungan.index') }}" class="btn btn-amber shadow-sm">
                        <i class="bi bi-calculator me-1"></i> Analisis SAW
                    </a>
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary shadow-sm">
                        <i class="bi bi-printer me-1"></i> Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">TOTAL VARIAN ROTI</div>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalVarian }}</h2>
                        <small class="text-muted" style="font-size: 0.75rem;">Alternatif Produksi</small>
                    </div>
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="bi bi-basket2-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">KRITERIA SAW</div>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalKriteria }}</h2>
                        <small class="text-muted" style="font-size: 0.75rem;">C1 s/d C5 (100% Bobot)</small>
                    </div>
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3 text-warning" style="color: #d97706 !important;">
                        <i class="bi bi-sliders fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">STATUS PERIODE</div>
                        <h5 class="fw-bold text-dark mt-2 mb-0">
                            @if($periodeTerbaru)
                                @if($periodeTerbaru->status === 'divalidasi')
                                    <span class="text-success"><i class="bi bi-check2-circle"></i> Divalidasi</span>
                                @elseif($periodeTerbaru->status === 'dihitung')
                                    <span class="text-primary"><i class="bi bi-calculator"></i> Dihitung</span>
                                @else
                                    <span class="text-secondary"><i class="bi bi-pencil-square"></i> Draft</span>
                                @endif
                            @else
                                <span class="text-muted">Belum Ada</span>
                            @endif
                        </h5>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $periodeTerbaru?->nama_periode ?? 'Belum ada periode' }}</small>
                    </div>
                    <div class="rounded-3 bg-info bg-opacity-10 p-3 text-info">
                        <i class="bi bi-calendar-check-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">PRIORITAS UTAMA #1</div>
                        @if($hasilTerbaru->isNotEmpty())
                            <h6 class="fw-bold text-success mt-2 mb-0 text-truncate" style="max-width: 150px;">
                                {{ $hasilTerbaru->first()->varianRoti->nama_varian }}
                            </h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Skor Vi: {{ $hasilTerbaru->first()->nilai_preferensi }}</small>
                        @else
                            <h6 class="text-muted mt-2 mb-0">Belum dihitung</h6>
                        @endif
                    </div>
                    <div class="rounded-3 bg-success bg-opacity-10 p-3 text-success">
                        <i class="bi bi-trophy-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Table Section -->
    <div class="row g-4">
        <!-- Visual Chart -->
        <div class="col-lg-7">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Grafik Nilai Preferensi (Vᵢ) Varian Roti</h6>
                        <small class="text-muted">Hasil kalkulasi algoritma SAW (Semakin tinggi skor, semakin prioritas)</small>
                    </div>
                    <span class="badge bg-light text-dark border">Periode: {{ $periodeTerbaru?->nama_periode ?? '-' }}</span>
                </div>
                <div style="height: 320px;">
                    <canvas id="rankingChart" 
                        data-labels="{{ json_encode($hasilTerbaru->map(fn($h) => $h->varianRoti->nama_varian)->values()) }}" 
                        data-scores="{{ json_encode($hasilTerbaru->map(fn($h) => (float)$h->nilai_preferensi)->values()) }}"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Summary Table -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Urutan Prioritas Produksi</h6>
                        <small class="text-muted">Rekomendasi untuk periode ini</small>
                    </div>
                    <a href="{{ route('perhitungan.index') }}" class="small text-decoration-none fw-semibold">Detail Matriks <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 45px;">Rank</th>
                                <th>Varian Roti</th>
                                <th class="text-center">Skor Vᵢ</th>
                                <th>Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilTerbaru->take(6) as $item)
                                <tr>
                                    <td>
                                        @if($item->ranking == 1)
                                            <span class="badge rounded-pill bg-warning text-dark fw-bold">1</span>
                                        @elseif($item->ranking == 2)
                                            <span class="badge rounded-pill bg-secondary text-white fw-bold">2</span>
                                        @elseif($item->ranking == 3)
                                            <span class="badge rounded-pill bg-dark text-white fw-bold">3</span>
                                        @else
                                            <span class="badge rounded-pill bg-light text-dark border">{{ $item->ranking }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $item->varianRoti->nama_varian }}</div>
                                        <small class="text-muted">{{ $item->varianRoti->kode }} • {{ $item->varianRoti->kategori }}</small>
                                    </td>
                                    <td class="text-center fw-bold text-primary">{{ $item->nilai_preferensi }}</td>
                                    <td>
                                        @if($item->rekomendasi === 'Prioritas Utama')
                                            <span class="badge badge-priority-utama">Utama</span>
                                        @elseif($item->rekomendasi === 'Prioritas Sedang')
                                            <span class="badge badge-priority-sedang">Sedang</span>
                                        @else
                                            <span class="badge badge-priority-rendah">Rendah</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data hasil perhitungan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const canvas = document.getElementById('rankingChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const dataScores = JSON.parse(canvas.dataset.scores || '[]');

        const backgroundColors = dataScores.map(score => {
            if (score >= 0.75) return '#10b981'; // Green
            if (score >= 0.65) return '#f59e0b'; // Amber
            return '#94a3b8'; // Slate
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nilai Preferensi (Vi)',
                    data: dataScores,
                    backgroundColor: backgroundColors,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        min: 0,
                        max: 1.0,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { family: 'Plus Jakarta Sans' } }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', weight: '500' } }
                    }
                }
            }
        });
    }
</script>
@endpush
