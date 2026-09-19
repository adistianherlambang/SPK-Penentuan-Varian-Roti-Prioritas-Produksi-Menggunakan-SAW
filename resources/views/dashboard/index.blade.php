@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-column gap-3">

    <!-- 1. HEADER RINGKAS -->
    <div class="card-custom p-3 px-4 bg-white">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0">Dashboard</h5>
                @if($periodeTerbaru)
                    <span class="small text-muted ms-2">
                        • {{ $periodeTerbaru->nama_periode }}
                    </span>
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('penilaian.index') }}" class="btn btn-sm btn-pill-light">
                    Penilaian
                </a>
                <a href="{{ route('perhitungan.index') }}" class="btn btn-sm btn-coral text-white">
                    Perhitungan SAW
                </a>
            </div>
        </div>
    </div>

    <!-- 2. METRIC CARDS -->
    <div class="row g-3">
        <!-- Prioritas #1 -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Prioritas #1</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #FEF2F2; color: #EF4444;">
                        <i class="bi bi-trophy-fill" style="font-size: 0.85rem;"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark fs-5 text-truncate">
                    {{ $hasilTerbaru->first()?->varianRoti?->nama_varian ?? '-' }}
                </div>
                <div class="text-danger small fw-semibold mt-1">
                    {{ $hasilTerbaru->first() ? 'Skor ' . number_format($hasilTerbaru->first()->nilai_preferensi, 4) : 'Belum dihitung' }}
                </div>
            </div>
        </div>

        <!-- Periode -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Periode</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ECFDF5; color: #10B981;">
                        <i class="bi bi-calendar3" style="font-size: 0.85rem;"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark fs-5">
                    {{ $periodeTerbaru?->nama_periode ?? '-' }}
                </div>
                <div class="text-muted small mt-1">
                    {{ $periodeTerbaru ? ucfirst($periodeTerbaru->status) : 'Tidak aktif' }}
                </div>
            </div>
        </div>

        <!-- Varian Roti -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Varian Roti</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #EFF6FF; color: #3B82F6;">
                        <i class="bi bi-basket2-fill" style="font-size: 0.85rem;"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark fs-5">
                    {{ $totalVarian }}
                </div>
                <div class="text-muted small mt-1">
                    Alternatif
                </div>
            </div>
        </div>

        <!-- Kriteria -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Kriteria</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #FFFBEB; color: #F59E0B;">
                        <i class="bi bi-sliders" style="font-size: 0.85rem;"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark fs-5">
                    {{ $totalKriteria }}
                </div>
                <div class="text-muted small mt-1">
                    Faktor evaluasi
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GRAFIK & TABEL -->
    <div class="row g-3">
        <!-- Grafik -->
        <div class="col-lg-7">
            <div class="card-custom p-4 bg-white h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Grafik Nilai Preferensi</h6>
                    <span class="small text-muted">{{ $periodeTerbaru?->nama_periode ?? '' }}</span>
                </div>
                <div class="position-relative flex-grow-1" style="min-height: 280px;">
                    <canvas id="rankingChart"
                        data-labels="{{ json_encode($hasilTerbaru->map(fn($h) => $h->varianRoti->nama_varian)->values()) }}"
                        data-scores="{{ json_encode($hasilTerbaru->map(fn($h) => (float)$h->nilai_preferensi)->values()) }}">
                    </canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Peringkat -->
        <div class="col-lg-5">
            <div class="card-custom p-4 bg-white h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Peringkat Prioritas</h6>
                    <a href="{{ route('perhitungan.index') }}" class="small text-muted text-decoration-none">
                        Semua <i class="bi bi-chevron-right"></i>
                    </a>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>Varian</th>
                                <th class="text-center">Skor</th>
                                <th class="text-end">Prioritas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilTerbaru->take(6) as $item)
                                <tr>
                                    <td class="text-center">
                                        <span class="fw-bold {{ $item->ranking == 1 ? 'text-danger' : 'text-dark' }}">{{ $item->ranking }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $item->varianRoti->nama_varian }}</span>
                                    </td>
                                    <td class="text-center fw-bold text-danger">
                                        {{ number_format($item->nilai_preferensi, 4) }}
                                    </td>
                                    <td class="text-end">
                                        @if($item->rekomendasi === 'Prioritas Utama')
                                            <span class="text-success fw-semibold small">Utama</span>
                                        @elseif($item->rekomendasi === 'Prioritas Sedang')
                                            <span class="text-warning fw-semibold small">Sedang</span>
                                        @else
                                            <span class="text-muted fw-semibold small">Rendah</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Tidak ada data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. BOTTOM ACTION STRIP -->
    <div class="bottom-banner-coral p-3 px-4">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-patch-check-fill text-white fs-5"></i>
            <span class="fw-semibold text-white">Rekomendasi Produksi Terhitung</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('laporan.index') }}" class="btn-pill-white text-decoration-none">
                Laporan
            </a>
            <a href="{{ route('perhitungan.index') }}" class="btn btn-outline-light rounded-pill px-3 py-1 text-decoration-none" style="font-size: 0.8rem;">
                Kalkulasi
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rankingCanvas = document.getElementById('rankingChart');
        if (rankingCanvas) {
            let labels = [];
            let scores = [];
            try {
                labels = JSON.parse(rankingCanvas.dataset.labels || '[]');
                scores = JSON.parse(rankingCanvas.dataset.scores || '[]');
            } catch(e) {
                console.error(e);
            }

            if (labels.length === 0) {
                labels = ['Roti Coklat', 'Roti Keju', 'Roti Abon', 'Roti Srikaya', 'Roti Pisang', 'Roti Kopi'];
                scores = [0.88, 0.76, 0.69, 0.61, 0.55, 0.42];
            }

            const barColors = scores.map((_, index) => {
                if (index === 0) return '#EF4444';
                if (index <= 2) return '#F87171';
                return '#FECACA';
            });

            new Chart(rankingCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: scores,
                        backgroundColor: barColors,
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 26,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ' Skor: ' + ctx.parsed.y.toFixed(4)
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#6B7280'
                            }
                        },
                        y: {
                            min: 0,
                            max: 1.0,
                            grid: { color: '#F3F4F6' },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#9CA3AF',
                                stepSize: 0.2
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
