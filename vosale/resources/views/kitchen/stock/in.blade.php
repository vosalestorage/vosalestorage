<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Barang Masuk Kitchen</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>body{background:#f5f6fa}.sidebar{min-height:100vh;background:#1a1a2e;width:250px;position:fixed;top:0;left:0}.sidebar .brand{color:#f39c12;font-size:1.4rem;font-weight:700;padding:24px 20px;border-bottom:1px solid rgba(255,255,255,.1)}.sidebar .nav-link{color:rgba(255,255,255,.7);padding:12px 20px;border-radius:8px;margin:2px 10px}.sidebar .nav-link:hover,.sidebar .nav-link.active{background:rgba(243,156,18,.2);color:#f39c12}.sidebar .nav-link i{margin-right:8px}.main-content{margin-left:250px;padding:30px}.card-main{border:none;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06)}.topbar{background:#fff;padding:16px 24px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);margin-bottom:24px;display:flex;justify-content:space-between;align-items:center}.stock-info{background:#f8f9fa;border-radius:8px;padding:10px 16px;font-size:.9rem}</style>
</head><body>
<div class="sidebar"><div class="brand"><i class="bi bi-egg-fried me-2"></i>Kitchen</div>
<nav class="nav flex-column mt-3">
<a href="/kitchen/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">INVENTARIS</div>
<a href="/kitchen/items" class="nav-link"><i class="bi bi-box-seam"></i> Data Barang</a>
<a href="/kitchen/stock/in" class="nav-link active"><i class="bi bi-arrow-down-circle"></i> Barang Masuk</a>
<a href="/kitchen/stock/out" class="nav-link"><i class="bi bi-arrow-up-circle"></i> Barang Keluar</a>
<a href="/kitchen/stock" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat Stok</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">LAPORAN</div>
<a href="/kitchen/report" class="nav-link"><i class="bi bi-bar-chart"></i> Statistik</a>
<div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">AKUN</div>
<form method="POST" action="/logout">@csrf<button type="submit" class="nav-link border-0 bg-transparent w-100 text-start"><i class="bi bi-box-arrow-left"></i> Logout</button></form>
</nav></div>
<div class="main-content">
<div class="topbar"><div><h5 class="mb-0 fw-bold">Barang Masuk — Kitchen</h5><small class="text-muted">Catat penambahan stok</small></div></div>
@if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@if($errors->any())<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="card card-main p-4 mb-4">
<h6 class="fw-bold mb-3"><i class="bi bi-arrow-down-circle text-success me-2"></i>Catat Barang Masuk</h6>
<form method="POST" action="/kitchen/stock/in">
@csrf
<div class="row g-3 align-items-end">
<div class="col-md-4"><label class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
<select name="item_id" id="item_select" class="form-select" required onchange="updateStockInfo(this)">
<option value="">-- Pilih Barang --</option>
@foreach($items as $item)<option value="{{ $item->id }}" data-stock="{{ $item->stock }}" data-unit="{{ $item->unit }}" {{ old('item_id')==$item->id?'selected':'' }}>{{ $item->name }}</option>@endforeach
</select></div>
<div class="col-md-2"><label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label><input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity',1) }}" required></div>
<div class="col-md-3"><label class="form-label fw-semibold">Keterangan</label><input type="text" name="note" class="form-control" placeholder="contoh: Restock dari supplier" value="{{ old('note') }}"></div>
<div class="col-md-3">
<div id="stock_info" class="stock-info mb-2 d-none">Stok saat ini: <strong id="current_stock">0</strong> <span id="unit_label"></span></div>
<button type="submit" class="btn btn-success w-100"><i class="bi bi-plus-circle me-1"></i> Tambah Stok</button>
</div>
</div>
</form>
</div>
<div class="card card-main">
<div class="card-header bg-white border-0 pt-4 px-4"><h6 class="fw-bold mb-0">Riwayat Barang Masuk</h6></div>
<div class="card-body p-0">
<table class="table table-hover mb-0">
<thead class="table-light"><tr><th class="ps-4">Waktu</th><th>Barang</th><th>Jumlah</th><th>Stok Sebelum</th><th>Stok Sesudah</th><th>Keterangan</th><th>Oleh</th></tr></thead>
<tbody>
@forelse($transactions as $trx)
<tr>
<td class="ps-4"><div>{{ $trx->created_at->format('d/m/Y') }}</div><small class="text-muted">{{ $trx->created_at->format('H:i') }}</small></td>
<td class="fw-semibold">{{ $trx->item->name ?? '-' }}</td>
<td><span class="badge bg-success">+{{ $trx->quantity }} {{ $trx->item->unit ?? '' }}</span></td>
<td>{{ $trx->stock_before }}</td><td>{{ $trx->stock_after }}</td>
<td>{{ $trx->note ?? '-' }}</td><td>{{ $trx->user->name ?? '-' }}</td>
</tr>
@empty
<tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada riwayat barang masuk</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateStockInfo(select){const o=select.options[select.selectedIndex];const info=document.getElementById('stock_info');if(select.value){document.getElementById('current_stock').textContent=o.dataset.stock;document.getElementById('unit_label').textContent=o.dataset.unit;info.classList.remove('d-none');}else{info.classList.add('d-none');}}
window.addEventListener('load',()=>{const s=document.getElementById('item_select');if(s.value)updateStockInfo(s);});
</script>
</body></html>
