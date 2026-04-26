<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User — Vosale</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{background:#f5f6fa}.sidebar{min-height:100vh;background:#1a1a2e;width:250px;position:fixed;top:0;left:0}.sidebar .brand{color:#e74c3c;font-size:1.4rem;font-weight:700;padding:24px 20px;border-bottom:1px solid rgba(255,255,255,.1)}.sidebar .nav-link{color:rgba(255,255,255,.7);padding:12px 20px;border-radius:8px;margin:2px 10px}.sidebar .nav-link:hover,.sidebar .nav-link.active{background:rgba(231,76,60,.2);color:#e74c3c}.sidebar .nav-link i{margin-right:8px}.main-content{margin-left:250px;padding:30px}.card-main{border:none;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06)}.topbar{background:#fff;padding:16px 24px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);margin-bottom:24px;display:flex;justify-content:space-between;align-items:center}
</style>
</head>
<body>
<div class="sidebar">
<div class="brand">Vosale</div>
<nav class="nav flex-column mt-3">
<a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">BAR & CAFE</div>
<a href="/bar/dashboard" class="nav-link"><i class="bi bi-cup-straw"></i> Dashboard Bar</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">KITCHEN</div>
<a href="/kitchen/dashboard" class="nav-link"><i class="bi bi-egg-fried"></i> Dashboard Kitchen</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">PENGATURAN</div>
<a href="/admin/users" class="nav-link active"><i class="bi bi-people"></i> Manajemen User</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">AKUN</div>
<form method="POST" action="/logout">@csrf<button type="submit" class="nav-link border-0 bg-transparent w-100 text-start"><i class="bi bi-box-arrow-left"></i> Logout</button></form>
</nav>
</div>
<div class="main-content">
<div class="topbar">
<div><h5 class="mb-0 fw-bold">Edit User</h5><small class="text-muted">Update data: <strong>{{ $user->name }}</strong></small></div>
<a href="/admin/users" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
</div>
<div class="card card-main p-4">
@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<form method="POST" action="/admin/users/{{ $user->id }}">
@csrf
@method('PUT')
<div class="row g-3">
<div class="col-md-6">
    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
</div>
<div class="col-md-6">
    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
</div>
<div class="col-md-6">
    <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
    <select name="role" class="form-select" required>
        <option value="super_admin" {{ old('role',$user->role)=='super_admin'?'selected':'' }}>Super Admin</option>
        <option value="bar" {{ old('role',$user->role)=='bar'?'selected':'' }}>Admin Bar</option>
        <option value="kitchen" {{ old('role',$user->role)=='kitchen'?'selected':'' }}>Admin Kitchen</option>
    </select>
</div>
<div class="col-md-6">
    <label class="form-label fw-semibold">Status</label>
    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Akun Aktif</label>
    </div>
</div>
<div class="col-12">
    <div class="alert alert-info d-flex align-items-center gap-2" style="background:#EFF6FF;border-color:#3B82F6;color:#1D4ED8">
        <i class="bi bi-info-circle"></i>
        <span>Untuk ganti password, gunakan tombol <strong>Reset Password</strong> di halaman daftar user.</span>
    </div>
</div>
<div class="col-12 d-flex gap-2 justify-content-end mt-2">
    <a href="/admin/users" class="btn btn-outline-secondary">Batal</a>
    <button type="submit" class="btn btn-warning px-4"><i class="bi bi-save me-1"></i> Update User</button>
</div>
</div>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
