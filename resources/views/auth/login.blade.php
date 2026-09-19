<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK SAW Pelangi Nusantara Food</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --coral-500: #EF4444;
            --coral-600: #DC2626;
            --coral-gradient: linear-gradient(135deg, #FF5B5B 0%, #E5383B 100%);
            --bg-app: #F5F6F8;
            --text-dark: #111827;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-app);
            background-image: radial-gradient(circle at 10% 20%, rgba(239, 68, 68, 0.05) 0%, transparent 40%),
                              radial-gradient(circle at 90% 80%, rgba(239, 68, 68, 0.04) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #EFF0F3;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.06), 0 4px 12px -2px rgba(0, 0, 0, 0.03);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .login-header {
            background: var(--coral-gradient);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .login-header::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-coral {
            background: var(--coral-gradient);
            border: none;
            color: #ffffff;
            font-weight: 700;
            border-radius: 9999px;
            padding: 0.65rem 1.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
        }

        .btn-coral:hover {
            background: linear-gradient(135deg, #F04438 0%, #C92A2A 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.4);
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--coral-500);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            border-color: #E5E7EB;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        .quick-btn {
            font-size: 0.78rem;
            border-radius: 9999px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-btn:hover {
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="d-inline-flex p-3 rounded-circle bg-white bg-opacity-20 mb-3 shadow-sm">
            <i class="bi bi-cup-hot-fill fs-2 text-white"></i>
        </div>
        <h4 class="fw-bold mb-1">PELANGI NUSANTARA FOOD</h4>
        <div class="text-white-50" style="font-size: 0.85rem;">SPK Penentuan Varian Roti Prioritas Produksi</div>
        <span class="badge bg-white text-danger mt-2 fw-bold px-3 py-1 rounded-pill" style="font-size: 0.75rem;">
            Metode Simple Additive Weighting (SAW)
        </span>
    </div>

    <div class="p-4 p-md-4">
        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3 border-0 rounded-3 d-flex align-items-center gap-2" style="font-size: 0.85rem; background-color: #FEF2F2; color: #991B1B;">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info py-2 px-3 mb-3 border-0 rounded-3" style="font-size: 0.85rem; background-color: #EFF6FF; color: #1E40AF;">
                {{ session('info') }}
            </div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-dark" style="font-size: 0.85rem;">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@pelangifood.com">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold text-dark" style="font-size: 0.85rem;">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                </div>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" style="accent-color: var(--coral-500);">
                <label class="form-check-label text-muted" for="remember" style="font-size: 0.85rem;">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-coral w-100 py-2 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
            </button>
        </form>

        <!-- Quick Fill Helper for Demo / Evaluation -->
        <div class="mt-4 pt-3 border-top border-light text-center">
            <small class="text-muted d-block mb-2" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Login Demo (1-Klik):</small>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-danger w-50 quick-btn" onclick="fillAdmin()">
                    <i class="bi bi-person-gear"></i> Admin (Ibu Dian)
                </button>
                <button type="button" class="btn btn-sm btn-outline-success w-50 quick-btn" onclick="fillManajemen()">
                    <i class="bi bi-shield-check"></i> Manajer (Pak Wisnu)
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function fillAdmin() {
        document.getElementById('email').value = 'admin@pelangifood.com';
        document.getElementById('password').value = 'admin123';
    }
    function fillManajemen() {
        document.getElementById('email').value = 'manajemen@pelangifood.com';
        document.getElementById('password').value = 'manajemen123';
    }
</script>
</body>
</html>
