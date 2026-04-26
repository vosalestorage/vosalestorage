<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Inventaris Kitchen</title>
<style>
body{font-family:Arial,sans-serif;font-size:12px}
h2{text-align:center;color:#f39c12}
p{text-align:center;color:#666}
table{width:100%;border-collapse:collapse;margin-top:20px}
th{background:#f39c12;color:white;padding:8px;text-align:left}
td{padding:6px 8px;border-bottom:1px solid #ddd}
tr:nth-child(even){background:#f9f9f9}
.badge-habis{background:#ffc107;color:#000;padding:2px 8px;border-radius:4px}
.badge-ok{background:#28a745;color:#fff;padding:2px 8px;border-radius:4px}
.footer{margin-top:20px;text-align:right;color:#999;font-size:10px}
</style>
</head>
<body>
<h2>Laporan Inventaris Kitchen — Vosale</h2>
<p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
<table>
<thead>
<tr><th>No</th><th>Nama Barang</th><th>Kategori</th><th>Satuan</th><th>Stok</th><th>Min. Stok</th><th>Harga</th><th>Status</th></tr>
</thead>
<tbody>
@foreach($items as $i => $item)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $item->name }}</td>
<td>{{ $item->category->name ?? '-' }}</td>
<td>{{ $item->unit }}</td>
<td>{{ $item->stock }}</td>
<td>{{ $item->minimum_stock }}</td>
<td>Rp {{ number_format($item->price,0,',','.') }}</td>
<td>@if($item->stock <= $item->minimum_stock)<span class="badge-habis">Hampir Habis</span>@else<span class="badge-ok">Tersedia</span>@endif</td>
</tr>
@endforeach
</tbody>
</table>
<div class="footer">Total: {{ $items->count() }} item | Stok menipis: {{ $lowStockItems->count() }} item</div>
</body>
</html>
