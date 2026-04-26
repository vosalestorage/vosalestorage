<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Admin — Vosale</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

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
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(231,76,60,.2);
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
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
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
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
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
    <div class="brand">Vosale</div>

    <nav class="nav flex-column mt-3">
        <a href="/admin/dashboard" class="nav-link active">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">
            BAR & CAFE
        </div>

        <a href="/bar/dashboard" class="nav-link">
            <i class="bi bi-cup-straw"></i> Dashboard Bar
        </a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">
            KITCHEN
        </div>

        <a href="/kitchen/dashboard" class="nav-link">
            <i class="bi bi-egg-fried"></i> Dashboard Kitchen
        </a>
        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">PENGATURAN</div>
        <a href="/admin/users" class="nav-link"><i class="bi bi-people"></i> Manajemen User</a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">
            AKUN
        </div>

        <form method="POST" action="/logout">
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
            <h5 class="mb-0 fw-bold">Dashboard Super Admin</h5>
            <small class="text-muted">
                Selamat datang, {{ auth()->user()->name }}
            </small>
        </div>

        <span class="badge bg-danger">Super Admin</span>
    </div>

    <!-- STAT -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-cup-straw"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:.8rem">Total Item Bar</div>
                        <div class="fw-bold fs-5">{{ $totalBar }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-egg-fried"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:.8rem">Total Item Kitchen</div>
                        <div class="fw-bold fs-5">{{ $totalKitchen }}</div>
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
                        <div class="text-muted" style="font-size:.8rem">Barang Masuk Hari Ini</div>
                        <div class="fw-bold fs-5">{{ $masukHariIni }}</div>
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
                        <div class="text-muted" style="font-size:.8rem">Stok Hampir Habis</div>
                        <div class="fw-bold fs-5">{{ $lowStock }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- MODULE -->
    <div class="row g-3">

        <div class="col-md-6">
            <div class="card card-stat p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-cup-straw text-danger me-2"></i>
                    Modul Bar & Cafe
                </h6>

                <p class="text-muted mb-3">
                    Kelola stok minuman, bahan bar, dan inventaris cafe.
                </p>

                <a href="/bar/dashboard" class="btn btn-danger btn-sm">
                    Buka Dashboard Bar
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-stat p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-egg-fried text-warning me-2"></i>
                    Modul Kitchen
                </h6>

                <p class="text-muted mb-3">
                    Kelola stok bahan masakan, bumbu, dan inventaris dapur.
                </p>

                <a href="/kitchen/dashboard" class="btn btn-warning btn-sm">
                    Buka Dashboard Kitchen
                </a>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>