@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-column gap-4">

    <!-- 1. HEADER RINGKASAN & STATUS PERIODE -->
    <div class="card-custom p-4 bg-white">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h4 class="fw-bold text-dark mb-1">Evaluasi Prioritas Produksi Roti</h4>
                <p class="text-muted small mb-0">
                    Sistem Pendukung Keputusan metode Simple Additive Weighting (SAW)
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if($periodeTerbaru)
                    <span class="badge {{ $periodeTerbaru->status === 'divalidasi' ? 'badge-mint-pill' : 'badge-priority-sedang' }} px-3 py-2">
                        <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                        {{ $periodeTerbaru->nama_periode }} ({{ ucfirst($periodeTerbaru->status) }})
                    </span>
                @else
                    <span class="badge bg-light text-muted border px-3 py-2">
                        Belum Ada Periode
                    </span>
                @endif
                <a href="{{ route('perhitungan.index') }}" class="btn btn-sm btn-coral text-white px-3 py-2">
                    <i class="bi bi-calculator me-1"></i> Perhitungan SAW
                </a>
            </div>
        </div>
    </div>

    <!-- 2. METRIC STAT CARDS -->
    <div class="row g-3">
        <!-- Card 1: Prioritas Utama -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Prioritas #1</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #FEF2F2; color: #EF4444;">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                </div>
                <div>
                    @if($hasilTerbaru->isNotEmpty())
                        <div class="fw-bold text-dark fs-5 text-truncate" title="{{ $hasilTerbaru->first()->varianRoti->nama_varian }}">
                            {{ $hasilTerbaru->first()->varianRoti->nama_varian }}
                        </div>
                        <div class="text-danger small fw-semibold mt-1">
                            Skor Vᵢ: {{ number_format($hasilTerbaru->first()->nilai_preferensi, 4) }}
                        </div>
                    @else
                        <div class="fw-bold text-muted fs-6">Belum Dihitung</div>
                        <div class="text-muted small mt-1">Periode belum aktif</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card 2: Periode Aktif -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Periode Evaluasi</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #ECFDF5; color: #10B981;">
                        <i class="bi bi-calendar3"></i>
                    </div>
                </div>
                <div>
                    <div class="fw-bold text-dark fs-5">
                        {{ $periodeTerbaru ? $periodeTerbaru->nama_periode : 'Tidak Ada' }}
                    </div>
                    <div class="text-muted small mt-1">
                        {{ $periodeTerbaru ? 'Tahun ' . $periodeTerbaru->tahun : 'Silakan tambah periode' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Varian -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Alternatif Produk</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #EFF6FF; color: #3B82F6;">
                        <i class="bi bi-basket2-fill"></i>
                    </div>
                </div>
                <div>
                    <div class="fw-bold text-dark fs-5">
                        {{ $totalVarian }} <small class="text-muted fs-6 fw-normal">varian roti</small>
                    </div>
                    <div class="text-muted small mt-1">
                        Objek penilaian SAW
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Kriteria -->
        <div class="col-xl-3 col-md-6">
            <div class="card-custom p-3 bg-white h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold">Kriteria Penilaian</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #FFFBEB; color: #F59E0B;">
                        <i class="bi bi-sliders"></i>
                    </div>
                </div>
                <div>
                    <div class="fw-bold text-dark fs-5">
                        {{ $totalKriteria }} <small class="text-muted fs-6 fw-normal">faktor</small>
                    </div>
                    <div class="text-muted small mt-1">
                        Benefit dan Cost
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. INTI SPK SAW: GRAFIK & TABEL PERINGKAT -->
    <div class="row g-4">
        <!-- Kolom Kiri: Visualisasi Grafik Skor SAW -->
        <div class="col-lg-7">
            <div class="card-custom p-4 bg-white h-100 d-flex flex-column">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Grafik Nilai Preferensi (Vᵢ)</h5>
                        <small class="text-muted">Perbandingan skor SAW per varian roti</small>
                    </div>
                    <span class="badge bg-light text-dark border px-2 py-1 small">
                        {{ $periodeTerbaru ? $periodeTerbaru->nama_periode : 'Periode Terpilih' }}
                    </span>
                </div>

                <div class="position-relative flex-grow-1" style="min-height: 300px;">
                    <canvas id="rankingChart"
                        data-labels="{{ json_encode($hasilTerbaru->map(fn($h) => $h->varianRoti->nama_varian)->values()) }}"
                        data-scores="{{ json_encode($hasilTerbaru->map(fn($h) => (float)$h->nilai_preferensi)->values()) }}">
                    </canvas>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Tabel Urutan Prioritas -->
        <div class="col-lg-5">
            <div class="card-custom p-4 bg-white h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Urutan Prioritas</h5>
                        <small class="text-muted">Hasil perankingan rekomendasi</small>
                    </div>
                    <a href="{{ route('perhitungan.index') }}" class="small text-muted text-decoration-none">
                        Detail <i class="bi bi-chevron-right"></i>
                    </a>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">Rank</th>
                                <th>Varian Roti</th>
                                <th class="text-center">Skor Vᵢ</th>
                                <th class="text-end">Prioritas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilTerbaru->take(6) as $item)
                                <tr>
                                    <td>
                                        @if($item->ranking == 1)
                                            <span class="badge rounded-circle bg-danger text-white fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">1</span>
                                        @elseif($item->ranking == 2)
                                            <span class="badge rounded-circle text-white fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem; background-color: #F87171;">2</span>
                                        @elseif($item->ranking == 3)
                                            <span class="badge rounded-circle text-dark fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem; background-color: #FECACA;">3</span>
                                        @else
                                            <span class="badge rounded-circle bg-light text-muted border d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">{{ $item->ranking }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->varianRoti->nama_varian }}</div>
                                        <small class="text-muted">{{ $item->varianRoti->kode }} • {{ $item->varianRoti->kategori }}</small>
                                    </td>
                                    <td class="text-center fw-bold text-danger">
                                        {{ number_format($item->nilai_preferensi, 4) }}
                                    </td>
                                    <td class="text-end">
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
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Belum ada data perhitungan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($hasilTerbaru->count() > 6)
                    <div class="pt-3 border-top border-light text-center mt-auto">
                        <a href="{{ route('perhitungan.index') }}" class="small text-muted text-decoration-none">
                            Lihat seluruh {{ $hasilTerbaru->count() }} varian <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. BANNER AJAKAN / STATUS -->
    <div class="bottom-banner-coral">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 bg-white bg-opacity-20 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                <i class="bi bi-patch-check-fill text-white fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1 text-white">Keputusan Produksi Tepat & Terukur</h5>
                <p class="mb-0 text-white-50" style="font-size: 0.85rem;">
                    Gunakan hasil analisis SAW untuk menentukan jumlah produksi varian roti berdasarkan bobot kriteria objektif.
                </p>
            </div>
        </div>
        <div class="flex-shrink-0 d-flex gap-2">
            <a href="{{ route('laporan.index') }}" class="btn-pill-white text-decoration-none">
                Lihat Laporan
            </a>
            <a href="{{ route('perhitungan.index') }}" class="btn btn-outline-light rounded-pill px-3 py-2 text-decoration-none" style="font-size: 0.82rem;">
                Kalkulasi SAW
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

            // Warna bar: peringkat 1 coral pekat, lainnya proporsional
            const barColors = scores.map((score, index) => {
                if (index === 0) return '#EF4444';
                if (index <= 2) return '#F87171';
                return '#FECACA';
            });

            new Chart(rankingCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nilai Preferensi (Vᵢ)',
                        data: scores,
                        backgroundColor: barColors,
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 28,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Skor Vᵢ: ' + context.parsed.y.toFixed(4);
                                }
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
