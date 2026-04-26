<?php
namespace App\Http\Controllers\Kitchen;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function inIndex()
    {
        $items = Item::where('module','kitchen')->orderBy('name')->get();
        $transactions = StockTransaction::with(['item','user'])
            ->whereHas('item', fn($q) => $q->where('module','kitchen'))
            ->where('type','in')->latest()->paginate(10);
        return view('kitchen.stock.in', compact('items','transactions'));
    }
    public function storeIn(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:255',
        ]);
        DB::transaction(function() use ($request) {
            $item = Item::findOrFail($request->item_id);
            $before = $item->stock;
            $after  = $before + $request->quantity;
            $item->update(['stock' => $after]);
            StockTransaction::create([
                'item_id'      => $item->id,
                'user_id'      => Auth::id(),
                'type'         => 'in',
                'quantity'     => $request->quantity,
                'stock_before' => $before,
                'stock_after'  => $after,
                'note'         => $request->note,
            ]);
        });
        return redirect()->route('kitchen.stock.in')->with('success','Stok berhasil ditambahkan!');
    }
    public function outIndex()
    {
        $items = Item::where('module','kitchen')->orderBy('name')->get();
        $transactions = StockTransaction::with(['item','user'])
            ->whereHas('item', fn($q) => $q->where('module','kitchen'))
            ->where('type','out')->latest()->paginate(10);
        return view('kitchen.stock.out', compact('items','transactions'));
    }
    public function storeOut(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:255',
        ]);
        $item = Item::findOrFail($request->item_id);
        if ($request->quantity > $item->stock) {
            return back()->withErrors(['quantity' => "Stok tidak cukup! Tersedia: {$item->stock} {$item->unit}"])->withInput();
        }
        DB::transaction(function() use ($request, $item) {
            $before = $item->stock;
            $after  = $before - $request->quantity;
            $item->update(['stock' => $after]);
            StockTransaction::create([
                'item_id'      => $item->id,
                'user_id'      => Auth::id(),
                'type'         => 'out',
                'quantity'     => $request->quantity,
                'stock_before' => $before,
                'stock_after'  => $after,
                'note'         => $request->note,
            ]);
        });
        return redirect()->route('kitchen.stock.out')->with('success','Stok berhasil dikurangi!');
    }
    public function history()
    {
        $transactions = StockTransaction::with(['item','user'])
            ->whereHas('item', fn($q) => $q->where('module','kitchen'))
            ->latest()->paginate(15);
        return view('kitchen.stock.index', compact('transactions'));
    }
}
