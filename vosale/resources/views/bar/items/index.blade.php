<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Barang Bar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{background:#f5f6fa}.sidebar{min-height:100vh;background:#1a1a2e;width:250px;position:fixed;top:0;left:0}.sidebar .brand{color:#e74c3c;font-size:1.4rem;font-weight:700;padding:24px 20px;border-bottom:1px solid rgba(255,255,255,.1)}.sidebar .nav-link{color:rgba(255,255,255,.7);padding:12px 20px;border-radius:8px;margin:2px 10px}.sidebar .nav-link:hover,.sidebar .nav-link.active{background:rgba(231,76,60,.2);color:#e74c3c}.sidebar .nav-link i{margin-right:8px}.main-content{margin-left:250px;padding:30px}.card-main{border:none;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06)}.topbar{background:#fff;padding:16px 24px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);margin-bottom:24px;display:flex;justify-content:space-between;align-items:center}
</style>
</head>
<body>
<div class="sidebar">
<div class="brand"><i class="bi bi-cup-straw me-2"></i>Bar & Cafe</div>
<nav class="nav flex-column mt-3">
<a href="/bar/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">INVENTARIS</div>
<a href="/bar/items" class="nav-link active"><i class="bi bi-box-seam"></i> Data Barang</a>
<a href="/bar/stock/in" class="nav-link"><i class="bi bi-arrow-down-circle"></i> Barang Masuk</a>
<a href="/bar/stock/out" class="nav-link"><i class="bi bi-arrow-up-circle"></i> Barang Keluar</a>
<a href="/bar/stock" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat Stok</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">LAPORAN</div>
<a href="/bar/report" class="nav-link"><i class="bi bi-bar-chart"></i> Statistik</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">AKUN</div>
<form method="POST" action="/logout">@csrf<button type="submit" class="nav-link border-0 bg-transparent w-100 text-start"><i class="bi bi-box-arrow-left"></i> Logout</button></form>
</nav>
</div>

<div class="main-content">
<div class="topbar">
<div><h5 class="mb-0 fw-bold">Data Barang Bar</h5><small class="text-muted">Kelola inventaris bar & cafe</small></div>
<a href="/bar/items/create" class="btn btn-danger btn-sm"><i class="bi bi-plus-circle me-1"></i> Tambah Barang</a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<!-- Search & Filter -->
<div class="card card-main p-3 mb-4">
<form method="GET" action="/bar/items">
<div class="row g-2 align-items-end">
    <div class="col-md-4">
        <label class="form-label fw-semibold mb-1" style="font-size:.85rem">Cari Barang</label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Nama barang..." value="{{ request('search') }}">
        </div>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold mb-1" style="font-size:.85rem">Kategori</label>
        <select name="category_id" class="form-select">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold mb-1" style="font-size:.85rem">Status Stok</label>
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="ok" {{ request('status')=='ok'?'selected':'' }}>Tersedia</option>
            <option value="low" {{ request('status')=='low'?'selected':'' }}>Hampir Habis</option>
        </select>
    </div>
    <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-danger w-100"><i class="bi bi-funnel me-1"></i>Filter</button>
        <a href="/bar/items" class="btn btn-outline-secondary w-100"><i class="bi bi-x"></i></a>
    </div>
</div>
</form>
</div>

<!-- Hasil filter info -->
@if(request()->hasAny(['search','category_id','status']))
<div class="mb-3">
    <small class="text-muted">
        Menampilkan <strong>{{ $items->total() }}</strong> barang
        @if(request('search')) dengan kata kunci "<strong>{{ request('search') }}</strong>"@endif
        @if(request('status')=='low') yang <strong>hampir habis</strong>@endif
        @if(request('status')=='ok') yang <strong>tersedia</strong>@endif
    </small>
</div>
@endif

<div class="card card-main">
<div class="card-body p-0">
<table class="table table-hover mb-0">
<thead class="table-light">
<tr><th class="ps-4">No</th><th>Nama Barang</th><th>Kategori</th><th>Satuan</th><th>Stok</th><th>Min. Stok</th><th>Harga</th><th>Status</th><th class="text-center">Aksi</th></tr>
</thead>
<tbody>
@forelse($items as $item)
<tr>
<td class="ps-4">{{ $loop->iteration }}</td>
<td class="fw-semibold">{{ $item->name }}</td>
<td>{{ $item->category->name ?? '-' }}</td>
<td>{{ $item->unit }}</td>
<td><span class="fw-bold {{ $item->isLowStock() ? 'text-danger' : 'text-success' }}">{{ $item->stock }}</span></td>
<td>{{ $item->minimum_stock }}</td>
<td>Rp {{ number_format($item->price,0,',','.') }}</td>
<td>@if($item->isLowStock())<span class="badge bg-warning text-dark">Hampir Habis</span>@else<span class="badge bg-success">Tersedia</span>@endif</td>
<td class="text-center">
<a href="/bar/items/{{ $item->id }}/edit" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
<form action="/bar/items/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
</form>
</td>
</tr>
@empty
<tr><td colspan="9" class="text-center py-5 text-muted">
<i class="bi bi-inbox fs-1 d-block mb-2"></i>
@if(request()->hasAny(['search','category_id','status']))
    Tidak ada barang yang sesuai filter
@else
    Belum ada data barang
@endif
</td></tr>
@endforelse
</tbody>
</table>
</div>
@if($items->hasPages())
<div class="card-footer bg-white border-0 py-3">{{ $items->links() }}</div>
@endif
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
