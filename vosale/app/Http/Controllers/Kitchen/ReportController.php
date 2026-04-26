<?php
namespace App\Http\Controllers\Kitchen;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\StockTransaction;
use App\Exports\KitchenExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->where('module','kitchen')->get();
        $last7days = collect(range(6,0))->map(function($day) {
            $date = now()->subDays($day);
            return [
                'date'   => $date->format('d/m'),
                'masuk'  => StockTransaction::whereHas('item', fn($q) => $q->where('module','kitchen'))->where('type','in')->whereDate('created_at',$date)->count(),
                'keluar' => StockTransaction::whereHas('item', fn($q) => $q->where('module','kitchen'))->where('type','out')->whereDate('created_at',$date)->count(),
            ];
        });
        $lowStockItems = Item::with('category')->where('module','kitchen')->whereColumn('stock','<=','minimum_stock')->get();
        $totalItems    = $items->count();
        $totalMasuk    = StockTransaction::whereHas('item', fn($q) => $q->where('module','kitchen'))->where('type','in')->count();
        $totalKeluar   = StockTransaction::whereHas('item', fn($q) => $q->where('module','kitchen'))->where('type','out')->count();
        $totalLowStock = $lowStockItems->count();
        return view('kitchen.report', compact('items','last7days','lowStockItems','totalItems','totalMasuk','totalKeluar','totalLowStock'));
    }

    public function exportExcel()
    {
        return Excel::download(new KitchenExport, 'inventaris-kitchen-'.date('Y-m-d').'.xlsx');
    }

    public function exportPdf()
    {
        $items = Item::with('category')->where('module', 'kitchen')->get();
        $lowStockItems = Item::with('category')->where('module','kitchen')->whereColumn('stock','<=','minimum_stock')->get();
        $pdf = Pdf::loadView('exports.kitchen-pdf', compact('items','lowStockItems'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('inventaris-kitchen-'.date('Y-m-d').'.pdf');
    }
}
