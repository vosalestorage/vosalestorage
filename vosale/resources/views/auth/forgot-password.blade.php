<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password — Vosale</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f0f2f5;min-height:100vh;display:flex;align-items:center;justify-content:center}
.card{border:none;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,0.08)}
.btn-primary{background:#e74c3c;border:none}
.btn-primary:hover{background:#c0392b}
.brand-title{color:#e74c3c;font-weight:700;font-size:1.8rem}
</style>
</head>
<body>
<div class="container">
<div class="row justify-content-center">
<div class="col-md-4">
<div class="card p-4">
    <div class="text-center mb-4">
        <h1 class="brand-title">Vosale</h1>
        <p class="text-muted">Reset Password</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <p class="text-muted small mb-3">Masukkan email akun kamu. Kami akan mengirimkan link untuk reset password.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control"
                placeholder="email@example.com"
                value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">
            Kirim Link Reset Password
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
        </a>
    </div>
</div>
</div>
</div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
