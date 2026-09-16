<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK SAW Pelangi Nusantara Food</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            color: #ffffff;
        }
        .btn-amber {
            background-color: #d97706;
            border-color: #d97706;
            color: #ffffff;
            font-weight: 600;
        }
        .btn-amber:hover {
            background-color: #b45309;
            border-color: #b45309;
            color: #ffffff;
        }
        .quick-btn {
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .quick-btn:hover {
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="d-inline-flex p-3 rounded-circle bg-white bg-opacity-20 mb-3">
            <i class="bi bi-cup-hot-fill fs-2"></i>
        </div>
        <h4 class="fw-bold mb-1">PELANGI NUSANTARA FOOD</h4>
        <div class="text-white-50" style="font-size: 0.85rem;">SPK Penentuan Varian Roti Prioritas Produksi</div>
        <span class="badge bg-white text-dark mt-2 fw-semibold px-2 py-1" style="font-size: 0.75rem;">
            Metode Simple Additive Weighting (SAW)
        </span>
    </div>

    <div class="p-4 p-md-4">
        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3 border-0" style="font-size: 0.85rem;">
                <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info py-2 px-3 mb-3 border-0" style="font-size: 0.85rem;">
                {{ session('info') }}
            </div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold" style="font-size: 0.85rem;">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@pelangifood.com">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold" style="font-size: 0.85rem;">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                </div>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label text-muted" for="remember" style="font-size: 0.85rem;">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-amber w-100 py-2 mb-3 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
            </button>
        </form>

        <!-- Quick Fill Helper for Demo / Evaluation -->
        <div class="mt-4 pt-3 border-top text-center">
            <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">PILIHAN LOGIN DEMO (1-KLIK):</small>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary w-50 quick-btn" onclick="fillAdmin()">
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
