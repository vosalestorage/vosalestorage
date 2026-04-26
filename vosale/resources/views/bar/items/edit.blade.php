<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang Bar — Vosale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f6fa; }
        .sidebar {
            min-height: 100vh;
            background: #1a1a2e;
            width: 250px;
            position: fixed;
            top: 0; left: 0;
        }
        .sidebar .brand {
            color: #e74c3c;
            font-size: 1.4rem;
            font-weight: 700;
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(231,76,60,0.2);
            color: #e74c3c;
        }
        .sidebar .nav-link i { margin-right: 8px; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-main {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .topbar {
            background: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand"><i class="bi bi-cup-straw me-2"></i>Bar & Cafe</div>
        <nav class="nav flex-column mt-3">
            <a href="{{ url('/bar/dashboard') }}" class="nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:0.75rem;">INVENTARIS</div>
            <a href="{{ route('bar.items.index') }}" class="nav-link active">
                <i class="bi bi-box-seam"></i> Data Barang
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-arrow-down-circle"></i> Barang Masuk
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-arrow-up-circle"></i> Barang Keluar
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-clock-history"></i> Riwayat Stok
            </a>
            <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:0.75rem;">LAPORAN</div>
            <a href="#" class="nav-link">
                <i class="bi bi-bar-chart"></i> Statistik
            </a>
            <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:0.75rem;">AKUN</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <div>
                <h5 class="mb-0 fw-bold">Edit Barang Bar</h5>
                <small class="text-muted">Update data barang: <strong>{{ $item->name }}</strong></small>
            </div>
            <a href="{{ route('bar.items.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card card-main p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('bar.items.update', $item) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $item->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Supplier</label>
                        <select name="supplier_id" class="form-select">
                            <option value="">-- Pilih Supplier (opsional) --</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}"
                                    {{ old('supplier_id', $item->supplier_id) == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                        <select name="unit" class="form-select" required>
                            <option value="">-- Pilih Satuan --</option>
                            @foreach(['pcs','botol','kg','liter','dus','sachet','gram'] as $unit)
                                <option value="{{ $unit }}"
                                    {{ old('unit', $item->unit) == $unit ? 'selected' : '' }}>
                                    {{ ucfirst($unit) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Stok tidak bisa diubah langsung, harus lewat transaksi -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stok Saat Ini</label>
                        <input type="text" class="form-control bg-light"
                            value="{{ $item->stock }} {{ $item->unit }}" disabled>
                        <small class="text-muted">Ubah stok lewat Barang Masuk/Keluar</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Minimum Stok <span class="text-danger">*</span></label>
                        <input type="number" name="minimum_stock" class="form-control"
                            value="{{ old('minimum_stock', $item->minimum_stock) }}" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="price" class="form-control"
                                value="{{ old('price', $item->price) }}" min="0">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $item->description) }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end mt-2">
                        <a href="{{ route('bar.items.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-1"></i> Update Barang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>