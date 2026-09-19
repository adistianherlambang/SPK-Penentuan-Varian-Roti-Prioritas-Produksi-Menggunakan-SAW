@extends('layouts.app')

@section('title', 'Suivi logistique')

@section('content')
<div class="d-flex flex-column gap-4">

    <!-- 1. TOP HERO MAP & STATUS CARD -->
    <div class="card-custom p-4 bg-white position-relative overflow-hidden">
        <!-- Status Filter Pill Tabs -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-coral text-white">
                    Semua
                </a>
                <a href="{{ route('periode.index') }}" class="btn btn-sm btn-pill-light">
                    Divalidasi
                </a>
                <a href="{{ route('penilaian.index') }}" class="btn btn-sm btn-pill-light">
                    Draft
                </a>
            </div>
            <span class="badge badge-mint-pill">
                SAW Aktif
            </span>
        </div>

        <div class="row align-items-center g-4">
            <!-- Left: Global Progression & Key Metrics -->
            <div class="col-lg-5">
                <div class="mb-3">
                    <div class="text-muted small fw-semibold mb-1">Status Evaluasi</div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h1 class="display-5 fw-bold text-dark mb-0">
                            {{ $periodeTerbaru && $periodeTerbaru->status === 'divalidasi' ? '100%' : ($hasilTerbaru->isNotEmpty() ? '85%' : '40%') }}
                        </h1>
                    </div>
                    <div class="progress mt-2" style="height: 6px; border-radius: 9999px; background-color: #FEE2E2;">
                        <div class="progress-bar" role="progressbar" 
                            @style([
                                'width: ' . ($periodeTerbaru && $periodeTerbaru->status === 'divalidasi' ? '100%' : ($hasilTerbaru->isNotEmpty() ? '85%' : '40%')),
                                'background: var(--coral-gradient)',
                                'border-radius: 9999px',
                            ])>
                        </div>
                    </div>
                </div>

                <!-- 2 Metric Indicator Boxes -->
                <div class="row g-2 pt-1">
                    <div class="col-6">
                        <div class="p-3 rounded-4" style="background-color: #FAFAFB; border: 1px solid #F0F2F5;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 26px; height: 26px; background-color: #FEF2F2; color: #EF4444;">
                                    <i class="bi bi-basket2-fill" style="font-size: 0.8rem;"></i>
                                </div>
                                <span class="text-muted small">Alternatif</span>
                            </div>
                            <div class="fw-bold text-dark fs-5">{{ $totalVarian }} <small class="text-muted fs-6 fw-normal">roti</small></div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="p-3 rounded-4" style="background-color: #FAFAFB; border: 1px solid #F0F2F5;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 26px; height: 26px; background-color: #FEF2F2; color: #EF4444;">
                                    <i class="bi bi-sliders" style="font-size: 0.8rem;"></i>
                                </div>
                                <span class="text-muted small">Kriteria</span>
                            </div>
                            <div class="fw-bold text-dark fs-5">{{ $totalKriteria }} <small class="text-muted fs-6 fw-normal">faktor</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Center/Right: Route Map with Red Dotted Path and Alert Box -->
            <div class="col-lg-7">
                <div class="position-relative p-3 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #F9FAFC 0%, #F4F6F9 100%); border: 1px solid #EEF0F4; min-height: 190px;">
                    <svg viewBox="0 0 500 180" class="w-100 h-100 position-absolute top-0 start-0 opacity-75" style="pointer-events: none;">
                        <path d="M20,40 Q150,20 250,60 T480,50" fill="none" stroke="#E5E7EB" stroke-width="6" stroke-linecap="round"/>
                        <path d="M50,140 Q180,120 300,150 T460,110" fill="none" stroke="#E5E7EB" stroke-width="5" stroke-linecap="round"/>
                        <path d="M120,10 Q140,90 220,160" fill="none" stroke="#E5E7EB" stroke-width="4"/>
                        <path d="M350,20 Q330,90 380,170" fill="none" stroke="#E5E7EB" stroke-width="4"/>
                        <path d="M60,130 Q160,50 260,120 T440,40" fill="none" stroke="#EF4444" stroke-width="3" stroke-dasharray="6,6" stroke-linecap="round"/>
                        <circle cx="60" cy="130" r="7" fill="#EF4444" stroke="#FFFFFF" stroke-width="3"/>
                        <circle cx="170" cy="78" r="6" fill="#EF4444" stroke="#FFFFFF" stroke-width="2"/>
                        <circle cx="260" cy="120" r="6" fill="#EF4444" stroke="#FFFFFF" stroke-width="2"/>
                        <circle cx="360" cy="80" r="6" fill="#EF4444" stroke="#FFFFFF" stroke-width="2"/>
                        <circle cx="440" cy="40" r="10" fill="none" stroke="#EF4444" stroke-width="2"/>
                        <circle cx="440" cy="40" r="5" fill="#EF4444"/>
                    </svg>

                    <div class="position-relative d-flex justify-content-end align-items-center h-100">
                        <div class="card border p-3 rounded-4" style="max-width: 230px; background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark small">Status</span>
                                <a href="{{ route('laporan.index') }}" class="text-muted" style="font-size: 0.72rem; text-decoration: none;">Detail</a>
                            </div>
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="bi bi-check2-circle text-danger fs-5"></i>
                                <div style="font-size: 0.78rem;" class="text-muted">
                                    <strong class="text-dark d-block">Hasil SAW Siap</strong>
                                    {{ $periodeTerbaru ? $periodeTerbaru->nama_periode : 'Periode aktif' }}
                                </div>
                            </div>
                            <a href="{{ route('perhitungan.index') }}" class="btn btn-sm btn-coral w-100 text-center justify-content-center" style="font-size: 0.75rem; padding: 0.35rem 0.65rem;">
                                Lihat Analisis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. MIDDLE ROW: PRIORITAS UTAMA & BOBOT KRITERIA -->
    <div class="row g-4">
        <!-- Detail Prioritas #1 -->
        <div class="col-lg-7">
            <div class="card-custom p-4 h-100 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Prioritas Produksi #1</h5>
                    <a href="{{ route('perhitungan.index') }}" class="small text-muted text-decoration-none">Detail <i class="bi bi-chevron-right"></i></a>
                </div>

                @php
                    $topProduct = $hasilTerbaru->first();
                @endphp

                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom border-light">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #FFE4E6 0%, #FECDD3 100%); color: #EF4444; font-size: 1.3rem; font-weight: 800;">
                            <i class="bi bi-cup-hot-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">{{ $topProduct?->varianRoti?->nama_varian ?? 'Roti Coklat Lumer' }}</h6>
                            <div class="text-muted small">{{ $topProduct?->varianRoti?->kode ?? 'A1' }} • {{ $topProduct?->varianRoti?->kategori ?? 'Roti Manis' }}</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="text-danger" style="font-size: 0.85rem;">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- 4 Metrics Columns -->
                <div class="row g-2 text-center align-items-center mb-3 py-1">
                    <div class="col-3">
                        <div class="text-muted small mb-1">Varian</div>
                        <div class="fw-bold text-danger fs-3 mb-0">{{ $totalVarian }}</div>
                    </div>

                    <div class="col-3">
                        <div class="text-muted small mb-1">Skor Vi</div>
                        <div class="position-relative d-inline-flex align-items-center justify-content-center">
                            @php
                                $scorePercent = $topProduct ? round($topProduct->nilai_preferensi * 100) : 88;
                                $dashOffset = 220 - (220 * $scorePercent) / 100;
                            @endphp
                            <svg width="60" height="60" viewBox="0 0 80 80">
                                <circle cx="40" cy="40" r="34" stroke="#FEE2E2" stroke-width="7" fill="none" />
                                <circle cx="40" cy="40" r="34" stroke="#EF4444" stroke-width="7" fill="none"
                                    stroke-linecap="round" stroke-dasharray="220" stroke-dashoffset="{{ $dashOffset }}" class="progress-ring-circle" />
                            </svg>
                            <span class="position-absolute fw-bold text-dark" style="font-size: 0.8rem;">
                                {{ $scorePercent }}%
                            </span>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="text-muted small mb-1">Periode</div>
                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">
                            {{ $periodeTerbaru ? $periodeTerbaru->nama_periode : date('M Y') }}
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="text-muted small mb-1">Status</div>
                        <span class="badge badge-mint-pill px-2 py-1">
                            Utama
                        </span>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light mt-auto">
                    <div>
                        <div class="text-muted small">Estimasi Margin</div>
                        <div class="fw-bold text-dark fs-5">
                            Rp {{ number_format($topProduct?->varianRoti?->estimasi_keuntungan ?? 1500, 0, ',', '.') }}
                        </div>
                    </div>
                    <span class="badge badge-mint-pill px-3 py-1">
                        Siap Produksi
                    </span>
                </div>
            </div>
        </div>

        <!-- Bobot Kriteria -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100 bg-white d-flex flex-direction-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Bobot Kriteria</h5>
                    <a href="{{ route('kriteria.index') }}" class="small text-muted text-decoration-none">Detail <i class="bi bi-chevron-right"></i></a>
                </div>

                <div class="text-center py-2 mb-3">
                    <div class="p-3 rounded-4 d-inline-block position-relative" style="background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%); border: 1px solid #E5E7EB; width: 100%;">
                        <div class="d-flex align-items-center justify-content-center">
                            <svg width="140" height="70" viewBox="0 0 160 90" fill="none">
                                <circle cx="45" cy="72" r="10" fill="#1F2937" stroke="#9CA3AF" stroke-width="2"/>
                                <circle cx="45" cy="72" r="4" fill="#E5E7EB"/>
                                <circle cx="125" cy="72" r="10" fill="#1F2937" stroke="#9CA3AF" stroke-width="2"/>
                                <circle cx="125" cy="72" r="4" fill="#E5E7EB"/>
                                <path d="M15 40 L35 25 L55 25 L55 68 L15 68 Z" fill="#FFFFFF" stroke="#D1D5DB" stroke-width="2"/>
                                <path d="M22 38 L34 29 L50 29 L50 48 L22 48 Z" fill="#E0F2FE"/>
                                <rect x="55" y="15" width="95" height="53" rx="6" fill="#EF4444" stroke="#DC2626" stroke-width="2"/>
                                <rect x="65" y="32" width="22" height="18" rx="2" fill="#D97706" opacity="0.8"/>
                                <rect x="90" y="24" width="26" height="26" rx="2" fill="#D97706" opacity="0.9"/>
                                <rect x="120" y="36" width="20" height="14" rx="2" fill="#B45309" opacity="0.8"/>
                                <line x1="55" y1="68" x2="150" y2="68" stroke="#374151" stroke-width="3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-baseline mb-1">
                        <span class="display-6 fw-bold text-dark">100<small class="fs-6 text-muted">%</small></span>
                        <span class="text-muted small">Bobot Terpenuhi</span>
                    </div>
                    <div class="progress" style="height: 6px; border-radius: 9999px; background-color: #FEE2E2;">
                        <div class="progress-bar" role="progressbar" style="width: 100%; background: var(--coral-gradient); border-radius: 9999px;"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light mt-auto">
                    <div>
                        <div class="text-muted small">Benefit</div>
                        <div class="fw-bold text-dark fs-5">3</div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">Cost</div>
                        <div class="fw-bold text-dark fs-5">2</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TREND & PERFORMANCE ROW -->
    <div class="row g-4">
        <!-- Trend Chart -->
        <div class="col-lg-7">
            <div class="card-custom p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Tren Nilai Preferensi</h5>
                        <small class="text-muted">Hasil perhitungan SAW</small>
                    </div>
                    <select class="select-pill" style="font-size: 0.78rem; padding: 0.35rem 1.8rem 0.35rem 0.9rem;">
                        <option>Periode ini</option>
                    </select>
                </div>

                <div style="height: 230px;" class="position-relative">
                    <canvas id="trendChart"
                        data-labels="{{ json_encode($hasilTerbaru->map(fn($h) => $h->varianRoti->nama_varian)->values()) }}"
                        data-scores="{{ json_encode($hasilTerbaru->map(fn($h) => (float)$h->nilai_preferensi)->values()) }}">
                    </canvas>
                </div>
            </div>
        </div>

        <!-- Red Performance Card -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100 position-relative overflow-hidden text-white" 
                style="background: var(--coral-card-gradient);">
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-white mb-0">Akurasi SAW</h6>
                    <span class="badge rounded-pill bg-white bg-opacity-20 text-white" style="font-size: 0.72rem; padding: 0.3rem 0.7rem;">
                        Bulan ini ▾
                    </span>
                </div>

                <div class="mb-2">
                    <div class="display-4 fw-bold text-white mb-0">94<small class="fs-5">%</small></div>
                    <div class="text-white-50 small">Tingkat efektivitas rekomendasi</div>
                </div>

                <div style="height: 90px;" class="mb-3">
                    <canvas id="redCardMiniChart"></canvas>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-20 mt-auto">
                    <div class="text-white-50 small">Target: 90%</div>
                    <a href="{{ route('laporan.index') }}" class="btn-pill-white text-decoration-none" style="font-size: 0.8rem; padding: 0.4rem 1rem;">
                        Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. BOTTOM ROW -->
    <div class="row g-4">
        <!-- Donut Chart -->
        <div class="col-lg-4">
            <div class="card-custom p-4 bg-white h-100">
                <h6 class="fw-bold text-dark mb-3">Proporsi Prioritas</h6>
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div style="width: 110px; height: 110px;">
                        <canvas id="donutPriorityChart"></canvas>
                    </div>
                    <div class="d-flex flex-column gap-2" style="font-size: 0.8rem;">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <span class="d-flex align-items-center gap-2 text-muted">
                                <span class="rounded-circle" style="width: 8px; height: 8px; background-color: #EF4444;"></span>
                                Utama
                            </span>
                            <span class="fw-bold text-dark">60%</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <span class="d-flex align-items-center gap-2 text-muted">
                                <span class="rounded-circle" style="width: 8px; height: 8px; background-color: #F87171;"></span>
                                Sedang
                            </span>
                            <span class="fw-bold text-dark">25%</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <span class="d-flex align-items-center gap-2 text-muted">
                                <span class="rounded-circle" style="width: 8px; height: 8px; background-color: #FECACA;"></span>
                                Rendah
                            </span>
                            <span class="fw-bold text-dark">15%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-lg-4">
            <div class="card-custom p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Skor Alternatif</h6>
                        <div class="fs-5 fw-bold text-dark mt-1">{{ $topProduct?->nilai_preferensi ?? '0.880' }}</div>
                    </div>
                    <span class="badge badge-mint-pill">+8%</span>
                </div>
                <div style="height: 130px;">
                    <canvas id="barScoreChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Activity -->
        <div class="col-lg-4">
            <div class="card-custom p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Aktivitas</h6>
                    <a href="{{ route('periode.index') }}" class="small text-muted text-decoration-none">Semua</a>
                </div>

                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; background: #EF4444; font-size: 0.75rem;">
                                D
                            </div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 0.82rem;">Ibu Dian</div>
                                <small class="text-muted" style="font-size: 0.72rem;">Input data operasional</small>
                            </div>
                        </div>
                        <span class="rounded-circle" style="width: 6px; height: 6px; background: #EF4444;"></span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; background: #10B981; font-size: 0.75rem;">
                                W
                            </div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 0.82rem;">Pak Wisnu</div>
                                <small class="text-muted" style="font-size: 0.72rem;">Validasi rekomendasi</small>
                            </div>
                        </div>
                        <span class="rounded-circle" style="width: 6px; height: 6px; background: #EF4444;"></span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold bg-light" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                A
                            </div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 0.82rem;">Alfonso</div>
                                <small class="text-muted" style="font-size: 0.72rem;">Kalkulasi SAW</small>
                            </div>
                        </div>
                        <small class="text-muted" style="font-size: 0.7rem;">Kemarin</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. BOTTOM BANNER -->
    <div class="bottom-banner-coral">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 bg-white bg-opacity-20 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                <i class="bi bi-truck text-white fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1 text-white">Optimalkan Keputusan Produksi Roti</h5>
                <p class="mb-0 text-white-50" style="font-size: 0.85rem;">
                    Rekomendasi objektif dan terukur berdasarkan 5 kriteria utama.
                </p>
            </div>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('perhitungan.index') }}" class="btn-pill-white text-decoration-none d-inline-flex align-items-center gap-2">
                <span>Mulai</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const trendCanvas = document.getElementById('trendChart');
        if (trendCanvas) {
            let labels = [];
            let scores = [];
            try {
                labels = JSON.parse(trendCanvas.dataset.labels || '[]');
                scores = JSON.parse(trendCanvas.dataset.scores || '[]');
            } catch(e) {
                console.error(e);
            }

            if (labels.length === 0) {
                labels = ['Roti Coklat', 'Roti Keju', 'Roti Abon', 'Roti Srikaya', 'Roti Pisang', 'Roti Kismis', 'Roti Kopi'];
                scores = [0.88, 0.76, 0.69, 0.61, 0.55, 0.48, 0.42];
            }

            new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Skor Vi',
                        data: scores,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.08)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#EF4444',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#9CA3AF' }
                        },
                        y: {
                            min: 0,
                            max: 1.0,
                            grid: { color: '#F3F4F6' },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#9CA3AF', stepSize: 0.25 }
                        }
                    }
                }
            });
        }

        const redMiniCanvas = document.getElementById('redCardMiniChart');
        if (redMiniCanvas) {
            new Chart(redMiniCanvas, {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7'],
                    datasets: [{
                        data: [65, 75, 70, 85, 80, 90, 94],
                        borderColor: '#FFFFFF',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#EF4444',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        tension: 0.35,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    scales: { x: { display: false }, y: { display: false } }
                }
            });
        }

        const donutCanvas = document.getElementById('donutPriorityChart');
        if (donutCanvas) {
            new Chart(donutCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Utama', 'Sedang', 'Rendah'],
                    datasets: [{
                        data: [60, 25, 15],
                        backgroundColor: ['#EF4444', '#F87171', '#FECACA'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: { legend: { display: false } }
                }
            });
        }

        const barCanvas = document.getElementById('barScoreChart');
        if (barCanvas) {
            new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7'],
                    datasets: [{
                        data: [88, 76, 69, 61, 55, 48, 42],
                        backgroundColor: '#F87171',
                        hoverBackgroundColor: '#EF4444',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: '#9CA3AF' } },
                        y: { display: false }
                    }
                }
            });
        }
    });
</script>
@endpush
