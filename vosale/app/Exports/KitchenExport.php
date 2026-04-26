<?php
namespace App\Exports;
use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KitchenExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Item::with('category')
            ->where('module', 'kitchen')
            ->get()
            ->map(function($item, $i) {
                return [
                    'No'            => $i + 1,
                    'Nama Barang'   => $item->name,
                    'Kategori'      => $item->category->name ?? '-',
                    'Satuan'        => $item->unit,
                    'Stok'          => $item->stock,
                    'Min. Stok'     => $item->minimum_stock,
                    'Harga'         => $item->price,
                    'Status'        => $item->stock <= $item->minimum_stock ? 'Hampir Habis' : 'Tersedia',
                ];
            });
    }

    public function headings(): array
    {
        return ['No','Nama Barang','Kategori','Satuan','Stok','Min. Stok','Harga (Rp)','Status'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
