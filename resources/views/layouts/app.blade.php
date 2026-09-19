<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SPK SAW Pelangi Nusantara Food</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
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
            --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            --card-shadow-hover: 0 12px 28px -4px rgba(239, 68, 68, 0.09), 0 6px 12px -2px rgba(0, 0, 0, 0.03);
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

        /* App Wrapper */
        .app-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling (Exact Screenshot Style) */
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

        /* User Profile in Sidebar */
        .sidebar-profile {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 2rem;
            padding-left: 0.5rem;
        }
        .profile-avatar-box {
            position: relative;
            margin-bottom: 0.75rem;
        }
        .profile-avatar {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFE4E6 0%, #FECDD3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--coral-500);
            border: 2px solid #FFFFFF;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
            overflow: hidden;
        }
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-status-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background-color: var(--mint-500);
            border: 2px solid #ffffff;
            border-radius: 50%;
        }
        .profile-greeting {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.2;
            margin-bottom: 0.15rem;
        }
        .profile-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
        }

        /* Sidebar Navigation */
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
        /* Active Nav Item: Coral Red Solid Pill (like "Vue d'ensemble" in screenshot) */
        .nav-item-link.active {
            background: var(--coral-gradient);
            color: #FFFFFF;
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.35);
        }
        .nav-item-link.active i {
            color: #FFFFFF;
        }
        .nav-badge-red {
            background-color: var(--coral-500);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            border-radius: 9999px;
            padding: 0.15rem 0.5rem;
            line-height: 1.2;
        }
        .nav-item-link.active .nav-badge-red {
            background-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }

        /* Sidebar Red Widget Card ("Dernières courses" style) */
        .sidebar-widget-red {
            background: var(--coral-card-gradient);
            border-radius: var(--card-radius);
            padding: 1.35rem 1.25rem;
            color: #FFFFFF;
            margin-top: 1.5rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 10px 25px -4px rgba(239, 68, 68, 0.35);
            position: relative;
            overflow: hidden;
        }
        .sidebar-widget-red::after {
            content: '';
            position: absolute;
            right: -25px;
            top: -25px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }
        .sidebar-widget-red .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .sidebar-widget-red .widget-title {
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .sidebar-widget-red .widget-sublink {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        .sidebar-widget-red .widget-stat {
            margin-bottom: 0.75rem;
        }
        .sidebar-widget-red .widget-stat-label {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.8);
            text-transform: capitalize;
        }
        .sidebar-widget-red .widget-stat-val {
            font-size: 1.05rem;
            font-weight: 800;
        }
        .btn-widget-white {
            background-color: #FFFFFF;
            color: var(--coral-500);
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.82rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-decoration: none;
            width: 100%;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-widget-white:hover {
            background-color: #FFFFFF;
            color: var(--coral-600);
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
        }

        /* Sidebar Mini Illustration Card (like bottom map/truck in screenshot) */
        .sidebar-mini-card {
            background: #FFFFFF;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 1rem;
        }
        .mini-card-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--coral-soft);
            color: var(--coral-500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-app);
        }

        /* Top Bar Header */
        .top-navbar {
            background-color: #FFFFFF;
            border-bottom: 1px solid var(--border-light);
            padding: 1.25rem 2.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .top-navbar .title-area .eyebrow {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.15rem;
        }
        .top-navbar .title-area .page-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0;
            line-height: 1.2;
        }
        .top-navbar .actions-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        /* Search pill */
        .search-pill-box {
            position: relative;
            width: 220px;
        }
        .search-pill-box input {
            border-radius: 9999px;
            border: 1px solid var(--border-subtle);
            padding: 0.5rem 1rem 0.5rem 2.25rem;
            font-size: 0.85rem;
            background-color: #FAFAFB;
            width: 100%;
            transition: all 0.2s ease;
        }
        .search-pill-box input:focus {
            background-color: #FFFFFF;
            border-color: var(--coral-500);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
            outline: none;
        }
        .search-pill-box i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-subtle);
            font-size: 0.85rem;
        }
        /* Filter pill select */
        .select-pill {
            border-radius: 9999px;
            border: 1px solid var(--border-subtle);
            padding: 0.5rem 2.25rem 0.5rem 1.15rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            background-color: #FAFAFB;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236B7280' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }
        .select-pill:focus {
            border-color: var(--coral-500);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
        }
        /* Notification Bell with Red Dot Badge */
        .btn-bell {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border-subtle);
            background-color: #FAFAFB;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-body);
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-bell:hover {
            background-color: #FFFFFF;
            border-color: var(--coral-500);
            color: var(--coral-500);
        }
        .bell-dot-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 16px;
            height: 16px;
            background-color: var(--coral-500);
            color: #ffffff;
            font-size: 0.65rem;
            font-weight: 800;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
        }

        /* Generic Card Styles (Exact 20px radius + Soft Shadows) */
        .card-custom {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-custom:hover {
            box-shadow: var(--card-shadow-hover);
        }

        /* Coral Pill Buttons */
        .btn-coral {
            background: var(--coral-gradient);
            color: #FFFFFF !important;
            border-radius: 9999px;
            padding: 0.55rem 1.4rem;
            font-weight: 700;
            font-size: 0.88rem;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.28);
            text-decoration: none;
        }
        .btn-coral:hover {
            background: linear-gradient(135deg, #F04438 0%, #C92A2A 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.38);
        }
        .btn-coral-outline {
            background: #FFFFFF;
            color: var(--coral-500) !important;
            border: 1px solid var(--coral-500);
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
            font-weight: 700;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-coral-outline:hover {
            background: var(--coral-soft);
            color: var(--coral-600) !important;
        }
        .btn-pill-light {
            background: #FAFAFB;
            color: var(--text-body);
            border: 1px solid var(--border-subtle);
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-pill-light:hover {
            background: #FFFFFF;
            color: var(--text-dark);
            border-color: #D1D5DB;
        }

        /* Pill Badges */
        .badge-coral-pill {
            background-color: var(--coral-soft);
            color: var(--coral-600);
            border: 1px solid var(--coral-soft-border);
            border-radius: 9999px;
            padding: 0.35rem 0.85rem;
            font-weight: 700;
            font-size: 0.78rem;
        }
        .badge-mint-pill {
            background-color: var(--mint-bg);
            color: var(--mint-text);
            border-radius: 9999px;
            padding: 0.35rem 0.85rem;
            font-weight: 700;
            font-size: 0.78rem;
        }
        .badge-gray-pill {
            background-color: #F3F4F6;
            color: #4B5563;
            border-radius: 9999px;
            padding: 0.35rem 0.85rem;
            font-weight: 600;
            font-size: 0.78rem;
        }

        /* Bottom Banner (Exact screenshot style) */
        .bottom-banner-coral {
            background: var(--coral-gradient);
            border-radius: var(--card-radius);
            padding: 1.5rem 2rem;
            color: #FFFFFF;
            box-shadow: 0 10px 30px -5px rgba(239, 68, 68, 0.4);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .bottom-banner-coral::before {
            content: '';
            position: absolute;
            left: -30px;
            bottom: -30px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }

        /* Circular Progress Ring */
        .progress-ring-circle {
            transition: stroke-dashoffset 0.5s ease-in-out;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        /* Form Controls Styled */
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid var(--border-subtle);
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--coral-500);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
            outline: none;
        }

        /* Table Modernization */
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
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-light);
            border-top: none;
        }
        .table-modern tbody td {
            padding: 1.1rem 1.25rem;
            color: var(--text-body);
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
            background-color: #FFFFFF;
        }
        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }
        .table-modern tbody tr:hover td {
            background-color: #FDFEFE;
        }

        /* Responsive Mobile Styles */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }
            .sidebar.show {
                transform: translateX(280px);
            }
            .top-navbar {
                padding: 1rem 1.25rem;
            }
            .search-pill-box {
                display: none;
            }
        }

        /* Custom Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F3F4F6;
        }
        ::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--coral-400);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar Navigation (Matching Screenshot) -->
        <aside class="sidebar" id="appSidebar">
            <!-- User Profile Header -->
            <div class="sidebar-profile">
                <div class="profile-avatar-box">
                    <div class="profile-avatar">
                        @if(auth()->check())
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @else
                            C
                        @endif
                    </div>
                    <div class="profile-status-dot"></div>
                </div>
                <div class="profile-greeting">Bonjour,</div>
                <div class="profile-name">{{ auth()->user()->name ?? 'Camille' }}</div>
                <span class="badge badge-mint-pill mt-1" style="font-size: 0.68rem; padding: 0.2rem 0.6rem;">
                    {{ auth()->user()->role ?? 'Admin Produksi' }}
                </span>
            </div>

            <!-- Navigation Links -->
            <nav class="sidebar-nav">
                <!-- Vue d'ensemble / Dashboard -->
                <a href="{{ route('dashboard') }}" class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Vue d'ensemble</span>
                    </div>
                </a>

                <!-- Kriteria & Bobot -->
                <a href="{{ route('kriteria.index') }}" class="nav-item-link {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-sliders"></i>
                        <span>Kriteria & Bobot</span>
                    </div>
                </a>

                <!-- Varian Roti (Alternatif) -->
                <a href="{{ route('varian.index') }}" class="nav-item-link {{ request()->routeIs('varian.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-basket2-fill"></i>
                        <span>Varian Roti</span>
                    </div>
                </a>

                <!-- Periode Produksi -->
                <a href="{{ route('periode.index') }}" class="nav-item-link {{ request()->routeIs('periode.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-calendar3"></i>
                        <span>Periode Produksi</span>
                    </div>
                </a>

                <!-- Data Operasional (X) -->
                <a href="{{ route('penilaian.index') }}" class="nav-item-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-table"></i>
                        <span>Data Operasional</span>
                    </div>
                    <span class="nav-badge-red">X</span>
                </a>

                <!-- Perhitungan SAW (Analyse) -->
                <a href="{{ route('perhitungan.index') }}" class="nav-item-link {{ request()->routeIs('perhitungan.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-calculator-fill"></i>
                        <span>Perhitungan SAW</span>
                    </div>
                    <span class="nav-badge-red">2</span>
                </a>

                <!-- Laporan Rekomendasi (Historique) -->
                <a href="{{ route('laporan.index') }}" class="nav-item-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <div class="nav-left">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        <span>Laporan Rekomendasi</span>
                    </div>
                    <span class="nav-badge-red">1</span>
                </a>
            </nav>

            <!-- Red Card Widget in Sidebar ("Dernières courses" Equivalent) -->
            <div class="sidebar-widget-red">
                <div class="widget-header">
                    <div>
                        <div class="widget-title">Ringkasan</div>
                        <div class="widget-title">Produksi</div>
                    </div>
                    <a href="{{ route('periode.index') }}" class="widget-sublink">Lihat semua</a>
                </div>
                
                <div class="widget-stat">
                    <div class="widget-stat-label">Periode Terkini</div>
                    <div class="widget-stat-val">
                        {{ \App\Models\Periode::latest()->first()?->nama_periode ?? 'Periode Aktif' }}
                    </div>
                </div>

                <div class="widget-stat">
                    <div class="widget-stat-label">Total Alternatif</div>
                    <div class="widget-stat-val">
                        {{ \App\Models\VarianRoti::count() }} Varian Roti
                    </div>
                </div>

                <div class="widget-stat">
                    <div class="widget-stat-label">Metode Evaluasi</div>
                    <div class="widget-stat-val" style="font-size: 0.95rem;">SAW (5 Kriteria)</div>
                </div>

                <a href="{{ route('penilaian.index') }}" class="btn-widget-white">
                    <i class="bi bi-plus-circle-fill"></i> Input Penilaian
                </a>
            </div>

            <!-- Mini Illustration Card in Sidebar (Warehouse & Delivery with Red Pin) -->
            <div class="sidebar-mini-card">
                <div class="mini-card-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div class="overflow-hidden">
                    <div class="fw-bold text-dark" style="font-size: 0.85rem; line-height: 1.2;">Pelangi Food</div>
                    <small class="text-muted text-truncate d-block" style="font-size: 0.72rem;">Metro Selatan, Lampung</small>
                </div>
            </div>

            <!-- User Logout Option -->
            <div class="pt-2 border-top border-light d-flex align-items-center justify-content-between">
                <small class="text-muted" style="font-size: 0.75rem;">SPK SAW &copy; {{ date('Y') }}</small>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 text-decoration-none fw-semibold" title="Keluar dari Sistem" style="font-size: 0.8rem;">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-wrapper">
            <!-- Top Navbar (Matching Screenshot) -->
            <header class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-light d-lg-none rounded-pill p-2" id="sidebarToggle" title="Buka Menu">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div class="title-area">
                        <div class="eyebrow">Tableau de bord • Sistem Pendukung Keputusan SAW</div>
                        <h1 class="page-title">@yield('title', 'Suivi logistique')</h1>
                    </div>
                </div>

                <div class="actions-area">
                    <!-- Period Filter Dropdown Pill -->
                    <select class="select-pill d-none d-md-block" onchange="if(this.value) window.location.href=this.value;">
                        <option value="{{ route('dashboard') }}">Pilih Periode Produksi ▾</option>
                        @foreach (\App\Models\Periode::latest()->take(5)->get() as $p)
                            <option value="{{ route('perhitungan.index', ['periode_id' => $p->id]) }}">
                                {{ $p->nama_periode }} ({{ ucfirst($p->status) }})
                            </option>
                        @endforeach
                    </select>

                    <!-- Search Pill -->
                    <div class="search-pill-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Rechercher...">
                    </div>

                    <!-- Notification Bell with Red Dot -->
                    <div class="btn-bell" title="Notifikasi Sistem">
                        <i class="bi bi-bell"></i>
                        <span class="bell-dot-badge">3</span>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="p-3 p-md-4 flex-grow-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm d-flex align-items-center gap-3 mb-4 p-3" role="alert" style="background-color: #ECFDF5; color: #065F46;">
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                        <div class="fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm d-flex align-items-center gap-3 mb-4 p-3" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>
                        <div class="fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show border-0 rounded-4 shadow-sm d-flex align-items-center gap-3 mb-4 p-3" role="alert" style="background-color: #EFF6FF; color: #1E40AF;">
                        <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
                        <div class="fw-semibold">{{ session('info') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Clean Minimal Footer -->
            <footer class="py-3 px-4 text-center text-muted border-top bg-white" style="font-size: 0.8rem;">
                SPK Varian Roti Prioritas Produksi &copy; {{ date('Y') }} — Skripsi Alfonso Yanuarvi (NPM: 22430109), Universitas Muhammadiyah Metro.
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle mobile sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        const appSidebar = document.getElementById('appSidebar');
        if (sidebarToggle && appSidebar) {
            sidebarToggle.addEventListener('click', () => {
                appSidebar.classList.toggle('show');
            });
            // Close when clicking outside on mobile
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
