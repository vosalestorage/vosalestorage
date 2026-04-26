<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Bar — Vosale</title>
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
        border-bottom: 1px solid rgba(255, 255, 255, .1);
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, .7);
        padding: 12px 20px;
        border-radius: 8px;
        margin: 2px 10px;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: rgba(231, 76, 60, .2);
        color: #e74c3c;
    }

    .sidebar .nav-link i {
        margin-right: 8px;
    }

    .main-content {
        margin-left: 250px;
        padding: 30px;
    }

    .card-main {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
    }

    .topbar {
        background: #fff;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        padding: 20px;
        background: white;
    }
</style>
</head>
<body>
    <div class="sidebar">
        <div class="brand"><i class="bi bi-cup-straw me-2"></i>Bar & Cafe</div>
        <nav class="nav flex-column mt-3">
            <a href="/bar/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">INVENTARIS</div>
            <a href="/bar/items" class="nav-link"><i class="bi bi-box-seam"></i> Data Barang</a>
            <a href="/bar/stock/in" class="nav-link"><i class="bi bi-arrow-down-circle"></i> Barang Masuk</a>
            <a href="/bar/stock/out" class="nav-link"><i class="bi bi-arrow-up-circle"></i> Barang Keluar</a>
            <a href="/bar/stock" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat Stok</a>
            <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">LAPORAN</div>
            <a href="/bar/report" class="nav-link active"><i class="bi bi-bar-chart"></i> Statistik</a>
            <div class="text-white-50 px-3 mt-3 mb-1" style="font-size:.75rem">AKUN</div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h5 class="mb-0 fw-bold">Statistik Bar & Cafe</h5>
                <small class="text-muted">Laporan dan grafik inventaris</small></div><div class="d-flex gap-2"><a href="/bar/export/excel" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Export Excel</a><a href="/bar/export/pdf" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>Export PDF</a>
            </div>
        </div>

        <!-- Summary -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;border-radius:12px;background:rgba(231,76,60,.1);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#e74c3c">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:.8rem">Total Item</div>
                            <div class="fw-bold fs-5">{{ $totalItems }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;border-radius:12px;background:rgba(40,167,69,.1);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#28a745">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:.8rem">Total Masuk</div>
                            <div class="fw-bold fs-5">{{ $totalMasuk }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;border-radius:12px;background:rgba(255,193,7,.1);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#ffc107">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:.8rem">Total Keluar</div>
                            <div class="fw-bold fs-5">{{ $totalKeluar }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;border-radius:12px;background:rgba(231,76,60,.1);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#e74c3c">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:.8rem">Stok Menipis</div>
                            <div class="fw-bold fs-5">{{ $totalLowStock }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="card card-main p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-graph-up me-2 text-danger"></i>Transaksi 7 Hari Terakhir</h6>
                    <canvas id="chartTransaksi" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-main p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-pie-chart me-2 text-danger"></i>Stok per Kategori</h6>
                    <canvas id="chartKategori" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card card-main p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart me-2 text-danger"></i>Stok Semua Barang</h6>
                    <canvas id="chartStok" height="80"></canvas>
                </div>
            </div>
        </div>
        <!-- Tabel Stok Menipis -->
        @if($lowStockItems->count() > 0)
        <div class="card card-main p-4">
            <h6 class="fw-bold mb-3 text-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Peringatan Stok Menipis
            </h6>
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Min. Stok</th>
                        <th>Kekurangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockItems as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td>{{ $item->category->name ?? '-' }}</td>
                        <td class="text-danger fw-bold">{{ $item->stock }}</td>
                        <td>{{ $item->minimum_stock }}</td>
                        <td>
                            <span class="badge bg-danger">
                                Kurang {{ $item->minimum_stock - $item->stock }} {{ $item->unit }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Ganti CDN chart.js lama dengan ini -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    const last7days = @json($last7days);
    const items = @json($items);

    window.addEventListener('load', function () {
        setTimeout(function () {

            // ✅ Chart Transaksi — bar tumbuh dari bawah
            new Chart(document.getElementById('chartTransaksi'), {
                type: 'bar',
                data: {
                    labels: last7days.map(d => d.date),
                    datasets: [
                        {
                            label: 'Barang Masuk',
                            data: last7days.map(d => d.masuk),
                            backgroundColor: 'rgba(40,167,69,0.7)',
                            borderRadius: 6
                        },
                        {
                            label: 'Barang Keluar',
                            data: last7days.map(d => d.keluar),
                            backgroundColor: 'rgba(231,76,60,0.7)',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart',
                        delay: (context) => context.dataIndex * 100 // tiap bar muncul bergantian
                    },
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // ✅ Chart Stok — bar tumbuh bergantian
            new Chart(document.getElementById('chartStok'), {
                type: 'bar',
                data: {
                    labels: items.map(i => i.name),
                    datasets: [
                        {
                            label: 'Stok Saat Ini',
                            data: items.map(i => i.stock),
                            backgroundColor: items.map(i =>
                                i.stock <= i.minimum_stock
                                    ? 'rgba(231,76,60,0.7)'
                                    : 'rgba(52,152,219,0.7)'
                            ),
                            borderRadius: 6
                        },
                        {
                            label: 'Minimum Stok',
                            data: items.map(i => i.minimum_stock),
                            backgroundColor: 'rgba(255,193,7,0.5)',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart',
                        delay: (context) => context.dataIndex * 150
                    },
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // ✅ Chart Doughnut — berputar saat muncul
            const categories = {};
            items.forEach(i => {
                const cat = i.category ? i.category.name : 'Lainnya';
                categories[cat] = (categories[cat] || 0) + i.stock;
            });

            new Chart(document.getElementById('chartKategori'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(categories),
                    datasets: [{
                        data: Object.values(categories),
                        backgroundColor: ['#e74c3c','#3498db','#2ecc71','#f39c12','#9b59b6','#1abc9c'],
                        borderWidth: 2
                    }]
                },
                options: {
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    },
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

        }, 100);
    });
</script>
</body>
</html>
