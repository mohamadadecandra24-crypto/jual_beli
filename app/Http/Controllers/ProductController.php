<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'image' => 'nullable|string|url|max:2048',
        ]);
        
        $data = $request->all();

        $product = Product::create($data);

        if ($product->stock > 0 && $product->buy_price > 0) {
            Expense::create([
                'expense_date' => now(),
                'description' => "Pembelian Stok Awal: {$product->name}",
                'qty' => $product->stock,
                'unit_price' => $product->buy_price,
                'amount' => $product->buy_price * $product->stock
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan dan pengeluaran awal tercatat otomatis.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'image' => 'nullable|string|url|max:2048',
        ]);
        
        $data = $request->all();

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diubah');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }

    public function restock(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $qty = intval($request->qty);
        $amount = $product->buy_price * $qty;

        Expense::create([
            'expense_date' => now(),
            'description' => "Pembelian Stok: {$product->name}",
            'qty' => $qty,
            'unit_price' => $product->buy_price,
            'amount' => $amount
        ]);

        $product->increment('stock', $qty);

        return redirect()->route('products.index')->with('success', "Stok {$product->name} berhasil ditambah sebanyak {$qty}. Pengeluaran sebesar Rp " . number_format($amount, 0, ',', '.') . " telah dicatat.");
    }
}
