<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Pelangi Food</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --coral-400: #F87171;
            --coral-500: #EF4444;
            --coral-600: #DC2626;
            --coral-gradient: linear-gradient(135deg, #FF5B5B 0%, #E5383B 100%);
            --coral-card-gradient: linear-gradient(145deg, #FF5757 0%, #E03E3E 100%);
            --coral-soft: #FEF2F2;
            --coral-soft-border: #FEE2E2;
            --bg-app: #F5F6F8;
            --sidebar-bg: #FFFFFF;
            --card-bg: #FFFFFF;
            --card-radius: 20px;
            --card-shadow: none;
            --card-shadow-hover: none;
            --text-dark: #111827;
            --text-body: #374151;
            --text-muted: #6B7280;
            --text-subtle: #9CA3AF;
            --border-light: #EFF0F3;
            --border-subtle: #E5E7EB;
            --mint-500: #10B981;
            --mint-bg: #D1FAE5;
            --mint-text: #047857;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-app);
            color: var(--text-body);
            min-height: 100vh;
            overflow-x: hidden;
            letter-spacing: -0.01em;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            min-width: 280px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            padding: 1.75rem 1.25rem 1.25rem;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1020;
            transition: transform 0.3s ease;
        }

        .sidebar-profile {
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--border-light);
        }
        .profile-avatar-box {
            position: relative;
        }
        .profile-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFE4E6 0%, #FECDD3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--coral-500);
            border: 2px solid #FFFFFF;
        }
        .profile-status-dot {
            position: absolute;
            bottom: 0px;
            right: 0px;
            width: 10px;
            height: 10px;
            background-color: var(--mint-500);
            border: 2px solid #ffffff;
            border-radius: 50%;
        }
        .profile-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
            margin-bottom: 0.15rem;
        }
        .profile-role {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.1;
        }

        /* Navigation */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            flex-grow: 1;
        }
        .nav-item-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 1.1rem;
            border-radius: 14px;
            color: #4B5563;
            font-weight: 600;
            font-size: 0.92rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .nav-item-link .nav-left {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }
        .nav-item-link i {
            font-size: 1.15rem;
            color: #6B7280;
            transition: color 0.2s ease;
        }
        .nav-item-link:hover {
            background-color: #F8F9FB;
            color: var(--text-dark);
        }
        .nav-item-link:hover i {
            color: var(--coral-500);
        }
        .nav-item-link.active {
            background: var(--coral-gradient);
            color: #FFFFFF;
        }
        .nav-item-link.active i {
            color: #FFFFFF;
        }

        /* Sidebar Red Widget Card */
        .sidebar-widget-red {
            background: var(--coral-card-gradient);
            border-radius: var(--card-radius);
            padding: 1.25rem;
            color: #FFFFFF;
            margin-top: 1.25rem;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }
        .sidebar-widget-red::after {
            content: '';
            position: absolute;
            right: -25px;
            top: -25px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }
        .sidebar-widget-red .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.85rem;
        }
        .sidebar-widget-red .widget-title {
            font-size: 0.92rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .sidebar-widget-red .widget-sublink {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
        }
        .sidebar-widget-red .widget-stat {
            margin-bottom: 0.65rem;
        }
        .sidebar-widget-red .widget-stat-label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .sidebar-widget-red .widget-stat-val {
            font-size: 1rem;
            font-weight: 800;
        }
        .btn-widget-white {
            background-color: #FFFFFF;
            color: var(--coral-500);
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 0.45rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-decoration: none;
            width: 100%;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-widget-white:hover {
            color: var(--coral-600);
            transform: translateY(-1px);
        }

        /* Sidebar Mini Illustration */
        .sidebar-mini-card {
            background: #FFFFFF;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.85rem;
        }
        .mini-card-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: var(--coral-soft);
            color: var(--coral-500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        /* Main Wrapper */
        .main-wrapper {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-app);
        }

        /* Top Bar */
        .top-navbar {
            background-color: #FFFFFF;
            border-bottom: 1px solid var(--border-light);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .top-navbar .title-area .eyebrow {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .top-navbar .title-area .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0;
            line-height: 1.2;
        }
        .top-navbar .actions-area {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }
        .search-pill-box {
            position: relative;
            width: 200px;
        }
        .search-pill-box input {
            border-radius: 9999px;
            border: 1px solid var(--border-subtle);
            padding: 0.45rem 1rem 0.45rem 2.2rem;
            font-size: 0.82rem;
            background-color: #FAFAFB;
            width: 100%;
        }
        .search-pill-box input:focus {
            background-color: #FFFFFF;
            border-color: var(--coral-500);
            outline: none;
        }
        .search-pill-box i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-subtle);
            font-size: 0.82rem;
        }
        .select-pill {
            border-radius: 9999px;
            border: 1px solid var(--border-subtle);
            padding: 0.45rem 2.2rem 0.45rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
            background-color: #FAFAFB;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236B7280' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }
        .select-pill:focus {
            border-color: var(--coral-500);
            outline: none;
        }

        /* Card Styles */
        .card-custom {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--card-radius);
            box-shadow: none;
            transition: transform 0.2s ease;
        }

        /* Buttons & Badges */
        .btn-coral {
            background: var(--coral-gradient);
            color: #FFFFFF !important;
            border-radius: 9999px;
            padding: 0.5rem 1.3rem;
            font-weight: 700;
            font-size: 0.85rem;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-coral:hover {
            background: linear-gradient(135deg, #F04438 0%, #C92A2A 100%);
            transform: translateY(-1px);
        }
        .btn-coral-outline {
            background: #FFFFFF;
            color: var(--coral-500) !important;
            border: 1px solid var(--coral-500);
            border-radius: 9999px;
            padding: 0.45rem 1.15rem;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }
        .btn-coral-outline:hover {
            background: var(--coral-soft);
        }
        .btn-pill-light {
            background: #FAFAFB;
            color: var(--text-body);
            border: 1px solid var(--border-subtle);
            border-radius: 9999px;
            padding: 0.45rem 1.15rem;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }
        .btn-pill-light:hover {
            background: #FFFFFF;
            color: var(--text-dark);
        }
        .btn-pill-white {
            background: #FFFFFF;
            color: var(--coral-500);
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.45rem 1.15rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-pill-white:hover {
            color: var(--coral-600);
            transform: translateY(-1px);
        }
        .btn-pill-outline-white {
            background: transparent;
            color: #FFFFFF;
            border: 1.5px solid rgba(255, 255, 255, 0.7);
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.45rem 1.15rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-pill-outline-white:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #FFFFFF;
            border-color: #FFFFFF;
            transform: translateY(-1px);
        }


        .bottom-banner-coral {
            background: var(--coral-gradient);
            border-radius: var(--card-radius);
            padding: 1.5rem 2rem;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.5s ease-in-out;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid var(--border-subtle);
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--coral-500);
            outline: none;
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-modern thead th {
            background-color: #F9FAFB;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.9rem 1.15rem;
            border-bottom: 1px solid var(--border-light);
        }
        .table-modern tbody td {
            padding: 1rem 1.15rem;
            color: var(--text-body);
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
            background-color: #FFFFFF;
        }
        .table-modern tbody tr:hover td {
            background-color: #FDFEFE;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
            }
            .sidebar.show {
                transform: translateX(280px);
            }
            .top-navbar {
                padding: 0.85rem 1.25rem;
            }
            .search-pill-box {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="appSidebar">
            <!-- Profile -->
            <div class="sidebar-profile">
                <div class="d-flex align-items-center gap-3 w-100">
                    <div class="profile-avatar-box position-relative flex-shrink-0">
                        <div class="profile-avatar">
                            @if(auth()->check())
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @else
                                A
                            @endif
                        </div>
                        <div class="profile-status-dot"></div>
                    </div>
                    <div class="overflow-hidden">
                        <div class="profile-name text-truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="profile-role text-truncate">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </div>
                </a>

                <a href="{{ route('kriteria.index') }}" class="nav-item-link {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-sliders"></i>
                        <span>Kriteria</span>
                    </div>
                </a>

                <a href="{{ route('varian.index') }}" class="nav-item-link {{ request()->routeIs('varian.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-basket2-fill"></i>
                        <span>Varian Roti</span>
                    </div>
                </a>

                <a href="{{ route('periode.index') }}" class="nav-item-link {{ request()->routeIs('periode.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-calendar3"></i>
                        <span>Periode</span>
                    </div>
                </a>

                <a href="{{ route('penilaian.index') }}" class="nav-item-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-table"></i>
                        <span>Data Operasional</span>
                    </div>
                </a>

                <a href="{{ route('perhitungan.index') }}" class="nav-item-link {{ request()->routeIs('perhitungan.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-calculator-fill"></i>
                        <span>Perhitungan SAW</span>
                    </div>
                </a>

                <a href="{{ route('laporan.index') }}" class="nav-item-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        <span>Laporan</span>
                    </div>
                </a>
            </nav>

            <!-- Red Card Widget -->
            <div class="sidebar-widget-red">
                <div class="widget-header">
                    <div class="widget-title">Ringkasan</div>
                    <a href="{{ route('periode.index') }}" class="widget-sublink">Lihat</a>
                </div>
                
                <div class="widget-stat">
                    <div class="widget-stat-label">Periode</div>
                    <div class="widget-stat-val">
                        {{ \App\Models\Periode::latest()->first()?->nama_periode ?? 'Aktif' }}
                    </div>
                </div>

                <div class="widget-stat">
                    <div class="widget-stat-label">Total Varian</div>
                    <div class="widget-stat-val">
                        {{ \App\Models\VarianRoti::count() }} Roti
                    </div>
                </div>

                <a href="{{ route('penilaian.index') }}" class="btn-widget-white">
                    <i class="bi bi-plus-circle-fill"></i> Penilaian
                </a>
            </div>

            <!-- Mini Illustration Card -->
            <div class="sidebar-mini-card">
                <div class="mini-card-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div class="overflow-hidden">
                    <div class="fw-bold text-dark small" style="line-height: 1.2;">Pelangi Food</div>
                    <small class="text-muted text-truncate d-block" style="font-size: 0.72rem;">Metro Selatan</small>
                </div>
            </div>

            <!-- Logout -->
            <div class="pt-2 border-top border-light d-flex align-items-center justify-content-between">
                <small class="text-muted" style="font-size: 0.75rem;">SPK SAW</small>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 text-decoration-none fw-semibold" style="font-size: 0.8rem;">
                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-wrapper">
            <!-- Top Navbar -->
            <header class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-light d-lg-none rounded-pill p-2" id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div class="title-area">
                        <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    </div>
                </div>
            </header>

            <!-- Body -->
            <main class="p-3 p-md-4 flex-grow-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 d-flex align-items-center gap-3 mb-4 p-3" role="alert" style="background-color: #ECFDF5; color: #065F46;">
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                        <div class="fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 d-flex align-items-center gap-3 mb-4 p-3" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>
                        <div class="fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Minimal Footer -->
            <footer class="py-3 px-4 text-center text-muted border-top bg-white" style="font-size: 0.78rem;">
                SPK Pelangi Food &copy; {{ date('Y') }}
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const appSidebar = document.getElementById('appSidebar');
        if (sidebarToggle && appSidebar) {
            sidebarToggle.addEventListener('click', () => appSidebar.classList.toggle('show'));
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 992 && !appSidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    appSidebar.classList.remove('show');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
