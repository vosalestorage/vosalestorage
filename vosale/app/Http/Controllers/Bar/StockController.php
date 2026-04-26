<?php

namespace App\Http\Controllers\Bar;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    // Barang Masuk
    public function inIndex()
    {
        $items = Item::where('module', 'bar')->orderBy('name')->get();
        $transactions = StockTransaction::with(['item', 'user'])
            ->whereHas('item', fn($q) => $q->where('module', 'bar'))
            ->where('type', 'in')
            ->latest()
            ->paginate(10);
        return view('bar.stock.in', compact('items', 'transactions'));
    }

    public function storeIn(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $item = Item::findOrFail($request->item_id);
            $stockBefore = $item->stock;
            $stockAfter  = $stockBefore + $request->quantity;

            $item->update(['stock' => $stockAfter]);

            StockTransaction::create([
                'item_id'      => $item->id,
                'user_id'      => Auth::id(),
                'type'         => 'in',
                'quantity'     => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after'  => $stockAfter,
                'note'         => $request->note,
            ]);
        });

        return redirect()->route('bar.stock.in')
            ->with('success', 'Stok berhasil ditambahkan!');
    }

    // Barang Keluar
    public function outIndex()
    {
        $items = Item::where('module', 'bar')->orderBy('name')->get();
        $transactions = StockTransaction::with(['item', 'user'])
            ->whereHas('item', fn($q) => $q->where('module', 'bar'))
            ->where('type', 'out')
            ->latest()
            ->paginate(10);
        return view('bar.stock.out', compact('items', 'transactions'));
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
            return back()->withErrors([
                'quantity' => "Stok tidak cukup! Stok tersedia: {$item->stock} {$item->unit}"
            ])->withInput();
        }

        DB::transaction(function () use ($request, $item) {
            $stockBefore = $item->stock;
            $stockAfter  = $stockBefore - $request->quantity;

            $item->update(['stock' => $stockAfter]);

            StockTransaction::create([
                'item_id'      => $item->id,
                'user_id'      => Auth::id(),
                'type'         => 'out',
                'quantity'     => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after'  => $stockAfter,
                'note'         => $request->note,
            ]);
        });

        return redirect()->route('bar.stock.out')
            ->with('success', 'Stok berhasil dikurangi!');
    }

    // Riwayat semua transaksi
    public function history()
    {
        $transactions = StockTransaction::with(['item', 'user'])
            ->whereHas('item', fn($q) => $q->where('module', 'bar'))
            ->latest()
            ->paginate(15);
        return view('bar.stock.index', compact('transactions'));
    }
}