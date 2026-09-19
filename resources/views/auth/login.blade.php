<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Pelangi Food</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            margin: 0;
        }

        /* Direct form container without boxed card wrapper */
        .login-form-container {
            width: 100%;
            max-width: 380px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--coral-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            padding: 0.75rem 1rem;
            font-size: 0.92rem;
            background-color: #FFFFFF;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--coral-500);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
            outline: none;
        }

        .btn-coral {
            background: var(--coral-gradient);
            border: none;
            color: #ffffff;
            font-weight: 700;
            border-radius: 9999px;
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.28);
        }

        .btn-coral:hover {
            background: linear-gradient(135deg, #F04438 0%, #C92A2A 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.38);
        }

        .quick-btn {
            font-size: 0.78rem;
            border-radius: 9999px;
            font-weight: 600;
            padding: 0.4rem 0.85rem;
            border: 1px solid #E5E7EB;
            background: #FFFFFF;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-btn:hover {
            border-color: var(--coral-500);
            color: var(--coral-500);
        }
    </style>
</head>
<body>

<div class="login-form-container">
    <!-- Brand & Title (Direct, Clean, No Card Wrapper) -->
    <div class="text-center mb-4">
        <div class="d-inline-flex brand-icon mb-3">
            <i class="bi bi-cup-hot-fill"></i>
        </div>
        <h3 class="fw-bold text-dark mb-1">Pelangi Food</h3>
        <p class="text-muted small mb-0">SPK Prioritas Produksi Roti</p>
    </div>

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

    <!-- Direct Form -->
    <form action="{{ route('login.attempt') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-dark small">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@pelangifood.com">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold text-dark small">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
        </div>

        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" style="accent-color: var(--coral-500);">
            <label class="form-check-label text-muted small" for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-coral w-100 mb-4">
            Masuk
        </button>
    </form>

    <!-- Quick Demo Buttons -->
    <div class="pt-3 border-top border-light text-center">
        <small class="text-muted d-block mb-2" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Akun Demo:</small>
        <div class="d-flex justify-content-center gap-2">
            <button type="button" class="quick-btn" onclick="fillAdmin()">
                Admin
            </button>
            <button type="button" class="quick-btn" onclick="fillManajemen()">
                Manajer
            </button>
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
