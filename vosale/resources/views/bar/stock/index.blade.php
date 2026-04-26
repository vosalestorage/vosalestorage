<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Stok Bar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background:#f5f6fa }

        .sidebar {
            min-height:100vh;
            background:#1a1a2e;
            width:250px;
            position:fixed;
            top:0;
            left:0;
        }

        .sidebar .brand {
            color:#e74c3c;
            font-size:1.4rem;
            font-weight:700;
            padding:24px 20px;
            border-bottom:1px solid rgba(255,255,255,.1);
        }

        .sidebar .nav-link {
            color:rgba(255,255,255,.7);
            padding:12px 20px;
            border-radius:8px;
            margin:2px 10px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background:rgba(231,76,60,.2);
            color:#e74c3c;
        }

        .sidebar .nav-link i {
            margin-right:8px;
        }

        .main-content {
            margin-left:250px;
            padding:30px;
        }

        .card-main {
            border:none;
            border-radius:12px;
            box-shadow:0 2px 12px rgba(0,0,0,.06);
        }

        .topbar {
            background:#fff;
            padding:16px 24px;
            border-radius:12px;
            box-shadow:0 2px 12px rgba(0,0,0,.06);
            margin-bottom:24px;
            display:flex;
            justify-content:space-between;
            align-items:center;
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
        <a href="/bar/dashboard" class="nav-link">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">
            INVENTARIS
        </div>

        <a href="/bar/items" class="nav-link">
            <i class="bi bi-box-seam"></i> Data Barang
        </a>

        <a href="/bar/stock/in" class="nav-link">
            <i class="bi bi-arrow-down-circle"></i> Barang Masuk
        </a>

        <a href="/bar/stock/out" class="nav-link">
            <i class="bi bi-arrow-up-circle"></i> Barang Keluar
        </a>

        <a href="/bar/stock" class="nav-link active">
            <i class="bi bi-clock-history"></i> Riwayat Stok
        </a>

        <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">
            LAPORAN
        </div>

        <a href="/bar/report" class="nav-link">
            <i class="bi bi-bar-chart"></i> Statistik
        </a>

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
            <h5 class="mb-0 fw-bold">Riwayat Stok Bar</h5>
            <small class="text-muted">Semua transaksi masuk dan keluar</small>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card card-main">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Waktu</th>
                        <th>Barang</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Keterangan</th>
                        <th>Oleh</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $trx)
                    <tr>
                        <td class="ps-4">
                            <div>{{ $trx->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $trx->created_at->format('H:i') }}</small>
                        </td>

                        <td class="fw-semibold">
                            {{ $trx->item->name ?? '-' }}
                        </td>

                        <td>
                            @if($trx->type=='in')
                                <span class="badge bg-success">
                                    <i class="bi bi-arrow-down me-1"></i>Masuk
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-arrow-up me-1"></i>Keluar
                                </span>
                            @endif
                        </td>

                        <td>
                            <span class="{{ $trx->type=='in' ? 'text-success' : 'text-danger' }} fw-bold">
                                {{ $trx->type=='in' ? '+' : '-' }}{{ $trx->quantity }} {{ $trx->item->unit ?? '' }}
                            </span>
                        </td>

                        <td>{{ $trx->stock_before }}</td>
                        <td>{{ $trx->stock_after }}</td>
                        <td>{{ $trx->note ?? '-' }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada riwayat transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>