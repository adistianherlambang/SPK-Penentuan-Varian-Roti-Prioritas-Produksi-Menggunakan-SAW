<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SPK SAW Pelangi Nusantara Food</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-amber: #d97706;
            --primary-hover: #b45309;
            --primary-light: #fef3c7;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --body-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: #334155;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 270px;
            background-color: var(--sidebar-bg);
            color: #cbd5e1;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar .brand-box {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar .nav-link {
            color: #94a3b8;
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            border-radius: 8px;
            margin: 0.2rem 0.75rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link i {
            font-size: 1.15rem;
            margin-right: 0.75rem;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #d97706, #b45309);
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.35);
        }

        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1.25rem 1.5rem 0.5rem;
            color: #64748b;
            font-weight: 700;
        }

        /* Content Area */
        .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.9rem 1.5rem;
        }

        /* Custom Cards */
        .card-custom {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        }

        .btn-amber {
            background-color: var(--primary-amber);
            border-color: var(--primary-amber);
            color: #ffffff;
        }
        .btn-amber:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            color: #ffffff;
        }

        .badge-priority-utama {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .badge-priority-sedang {
            background-color: #fef9c3;
            color: #a16207;
            border: 1px solid #fde047;
        }
        .badge-priority-rendah {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        /* Breadcrumb styling */
        .breadcrumb-item a {
            text-decoration: none;
            color: #64748b;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <aside class="sidebar d-flex flex-column">
            <div class="brand-box d-flex align-items-center gap-2">
                <div class="rounded-3 bg-warning bg-opacity-25 p-2 text-warning d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-cup-hot-fill fs-5 text-amber" style="color: #d97706;"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-white fw-bold">PELANGI FOOD</h6>
                    <small class="text-secondary" style="font-size: 0.75rem;">SPK Prioritas Roti (SAW)</small>
                </div>
            </div>

            <div class="flex-grow-1 overflow-y-auto py-2">
                <div class="sidebar-heading">Menu Utama</div>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sidebar-heading">Master Data SPK</div>
                <a href="{{ route('kriteria.index') }}" class="nav-link {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>Kriteria & Bobot</span>
                </a>
                <a href="{{ route('varian.index') }}" class="nav-link {{ request()->routeIs('varian.*') ? 'active' : '' }}">
                    <i class="bi bi-basket2-fill"></i>
                    <span>Varian Roti</span>
                </a>
                <a href="{{ route('periode.index') }}" class="nav-link {{ request()->routeIs('periode.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3"></i>
                    <span>Periode Produksi</span>
                </a>

                <div class="sidebar-heading">Proses & Analisis</div>
                <a href="{{ route('penilaian.index') }}" class="nav-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                    <i class="bi bi-table"></i>
                    <span>Data Operasional (X)</span>
                </a>
                <a href="{{ route('perhitungan.index') }}" class="nav-link {{ request()->routeIs('perhitungan.*') ? 'active' : '' }}">
                    <i class="bi bi-calculator-fill"></i>
                    <span>Perhitungan SAW</span>
                </a>

                <div class="sidebar-heading">Keputusan & Laporan</div>
                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    <span>Laporan Rekomendasi</span>
                </a>
            </div>

            <!-- User Info in Sidebar Footer -->
            <div class="p-3 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 overflow-hidden">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white fw-bold" style="width: 36px; height: 36px; min-width: 36px;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-white fw-semibold text-truncate" style="font-size: 0.85rem;">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                        <span class="badge {{ auth()->user()->isAdmin() ? 'bg-primary' : 'bg-success' }} px-2 py-0.5" style="font-size: 0.65rem;">
                            {{ strtoupper(auth()->user()->role ?? 'USER') }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary text-light border-0" title="Keluar">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Top Navbar -->
            <header class="top-navbar d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <span class="fw-semibold text-dark">Pelangi Nusantara Food (Roti Purnama)</span>
                        <span class="text-muted ms-2 d-none d-sm-inline" style="font-size: 0.8rem;">• Margodadi, Metro Selatan</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <small class="text-muted d-block" style="font-size: 0.75rem;">Metode SPK Terverifikasi</small>
                        <span class="badge bg-warning bg-opacity-25 text-warning fw-semibold px-2 py-1" style="color: #d97706 !important;">
                            Simple Additive Weighting (SAW)
                        </span>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="p-4 flex-grow-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div>{{ session('info') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="p-3 text-center text-muted border-top bg-white" style="font-size: 0.8rem;">
                SPK Varian Roti Prioritas Produksi &copy; {{ date('Y') }} — Skripsi Alfonso Yanuarvi (NPM: 22430109), Universitas Muhammadiyah Metro.
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
