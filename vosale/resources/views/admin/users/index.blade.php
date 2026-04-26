<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen User — Vosale</title>
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
<div><h5 class="mb-0 fw-bold">Manajemen User</h5><small class="text-muted">Kelola akun pengguna sistem</small></div>
<a href="/admin/users/create" class="btn btn-danger btn-sm"><i class="bi bi-plus-circle me-1"></i> Tambah User</a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card card-main">
<div class="card-body p-0">
<table class="table table-hover mb-0">
<thead class="table-light">
<tr><th class="ps-4">No</th><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th class="text-center">Aksi</th></tr>
</thead>
<tbody>
@foreach($users as $user)
<tr>
<td class="ps-4">{{ $loop->iteration }}</td>
<td class="fw-semibold">{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>
@if($user->role === 'super_admin')
    <span class="badge bg-danger">Super Admin</span>
@elseif($user->role === 'bar')
    <span class="badge bg-primary">Bar</span>
@else
    <span class="badge bg-warning text-dark">Kitchen</span>
@endif
</td>
<td>
@if($user->is_active)
    <span class="badge bg-success">Aktif</span>
@else
    <span class="badge bg-secondary">Nonaktif</span>
@endif
</td>
<td class="text-center">
    <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-outline-warning me-1">
        <i class="bi bi-pencil"></i>
    </a>
    <form action="/admin/users/{{ $user->id }}/reset-password" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-sm btn-outline-info me-1" onclick="return confirm('Reset password ke default?')" title="Reset Password">
            <i class="bi bi-key"></i>
        </button>
    </form>
    @if($user->id !== auth()->id())
    <form action="/admin/users/{{ $user->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
    </form>
    @endif
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
