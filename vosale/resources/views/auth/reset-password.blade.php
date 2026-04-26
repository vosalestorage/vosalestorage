<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — Vosale</title>
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
        <p class="text-muted">Buat Password Baru</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ request('email') }}">

        <div class="mb-3">
            <label class="form-label fw-semibold">Password Baru</label>
            <input type="password" name="password" class="form-control"
                placeholder="Minimal 8 karakter" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control"
                placeholder="Ulangi password baru" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">
            Reset Password
        </button>
    </form>
</div>
</div>
</div>
</div>
</body>
</html>
