<?php
namespace App\Http\Controllers\Bar;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category','supplier'])->where('module','bar');

        // Search
        if ($request->filled('search')) {
            $query->where('name','like','%'.$request->search.'%');
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter status stok
        if ($request->filled('status')) {
            if ($request->status === 'low') {
                $query->whereColumn('stock','<=','minimum_stock');
            } elseif ($request->status === 'ok') {
                $query->whereColumn('stock','>','minimum_stock');
            }
        }

        $items      = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::where('module','bar')->get();

        return view('bar.items.index', compact('items','categories'));
    }

    public function create()
    {
        $categories = Category::where('module','bar')->get();
        $suppliers  = Supplier::where('module','bar')->get();
        return view('bar.items.create', compact('categories','suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'unit'          => 'required|string|max:50',
            'stock'         => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'price'         => 'nullable|numeric|min:0',
            'description'   => 'nullable|string',
        ]);
        Item::create([
            'name'          => $request->name,
            'module'        => 'bar',
            'category_id'   => $request->category_id,
            'supplier_id'   => $request->supplier_id,
            'unit'          => $request->unit,
            'stock'         => $request->stock,
            'minimum_stock' => $request->minimum_stock,
            'price'         => $request->price ?? 0,
            'description'   => $request->description,
        ]);
        return redirect()->route('bar.items.index')->with('success','Barang berhasil ditambahkan!');
    }

    public function edit(Item $item)
    {
        $categories = Category::where('module','bar')->get();
        $suppliers  = Supplier::where('module','bar')->get();
        return view('bar.items.edit', compact('item','categories','suppliers'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'unit'          => 'required|string|max:50',
            'minimum_stock' => 'required|integer|min:0',
            'price'         => 'nullable|numeric|min:0',
            'description'   => 'nullable|string',
        ]);
        $item->update([
            'name'          => $request->name,
            'category_id'   => $request->category_id,
            'supplier_id'   => $request->supplier_id,
            'unit'          => $request->unit,
            'minimum_stock' => $request->minimum_stock,
            'price'         => $request->price ?? 0,
            'description'   => $request->description,
        ]);
        return redirect()->route('bar.items.index')->with('success','Barang berhasil diupdate!');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('bar.items.index')->with('success','Barang berhasil dihapus!');
    }
}
