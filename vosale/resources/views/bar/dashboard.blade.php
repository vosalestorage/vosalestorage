<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bar — Vosale</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background: #f5f6fa; }

        .sidebar {
            min-height: 100vh;
            background: #1a1a2e;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
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

        .sidebar .nav-link i {
            margin-right: 8px;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .card-stat .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .topbar {
            background: #fff;
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

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="brand">
        <i class="bi bi-cup-straw me-2"></i>Bar & Cafe
    </div>

    <nav class="nav flex-column mt-3">
        <a href="{{ url('/bar/dashboard') }}" class="nav-link active">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:0.75rem;">
            INVENTARIS
        </div>

        <a href="{{ route('bar.items.index') }}" class="nav-link">
            <i class="bi bi-box-seam"></i> Data Barang
        </a>

        <a href="{{ route('bar.stock.in') }}" class="nav-link">
            <i class="bi bi-arrow-down-circle"></i> Barang Masuk
        </a>

        <a href="{{ route('bar.stock.out') }}" class="nav-link">
            <i class="bi bi-arrow-up-circle"></i> Barang Keluar
        </a>

        <a href="{{ route('bar.stock.index') }}" class="nav-link">
            <i class="bi bi-clock-history"></i> Riwayat Stok
        </a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:0.75rem;">
            LAPORAN
        </div>

        <a href="/bar/report" class="nav-link">
            <i class="bi bi-bar-chart"></i> Statistik
        </a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:0.75rem;">
            AKUN
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            @auth
                @if(auth()->user()->role === 'super_admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light shadow-sm rounded-pill px-3 mb-2">
                        <i class="bi bi-arrow-left"></i> Admin
                    </a>
                @endif
            @endauth

            <h5 class="mb-0 fw-bold">Dashboard Bar & Cafe</h5>
            <small class="text-muted">
                Selamat datang, {{ auth()->user()->name }}
            </small>
        </div>

        <span class="badge bg-danger">Admin Bar</span>
    </div>

    <!-- STAT -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Total Item</div>
                        <div class="fw-bold fs-5">{{ $totalItems ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Masuk Hari Ini</div>
                        <div class="fw-bold fs-5">{{ $masukHariIni ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-arrow-up-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Keluar Hari Ini</div>
                        <div class="fw-bold fs-5">{{ $keluarHariIni ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Stok Hampir Habis</div>
                        <div class="fw-bold fs-5">{{ $lowStock ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- AKSI CEPAT -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card card-stat p-4">
                <h6 class="fw-bold mb-3">Aksi Cepat</h6>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('bar.items.create') }}" class="btn btn-danger">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Data Barang
                    </a>

                    <a href="{{ route('bar.stock.in') }}" class="btn btn-success">
                        <i class="bi bi-arrow-down-circle me-1"></i> Catat Barang Masuk
                    </a>

                    <a href="{{ route('bar.stock.out') }}" class="btn btn-warning">
                        <i class="bi bi-arrow-up-circle me-1"></i> Catat Barang Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card card-stat p-4">
        <h6 class="fw-bold mb-3">Stok Terkini</h6>

        @if(isset($items) && $items->count() > 0)

            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->name }}</td>
                            <td>{{ $item->category->name ?? '-' }}</td>

                            <td class="{{ $item->isLowStock() ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                {{ $item->stock }}
                            </td>

                            <td>{{ $item->unit }}</td>

                            <td>
                                @if($item->isLowStock())
                                    <span class="badge bg-warning text-dark">Hampir Habis</span>
                                @else
                                    <span class="badge bg-success">Tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else

            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Belum ada data barang.</p>

                <a href="{{ route('bar.items.create') }}" class="btn btn-danger btn-sm">
                    Tambah Barang
                </a>
            </div>

        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>