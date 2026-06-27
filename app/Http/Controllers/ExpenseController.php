<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'desc')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('expenses.create', compact('products'));
    }

    public function store(Request $request)
    {
        if ($request->expense_type === 'restock') {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'qty' => 'required|integer|min:1',
                'expense_date' => 'required|date',
            ]);
            $product = Product::findOrFail($request->product_id);
            $qty = intval($request->qty);
            $amount = $product->buy_price * $qty;
            
            Expense::create([
                'expense_date' => $request->expense_date,
                'description' => "Pembelian Stok: {$product->name}",
                'qty' => $qty,
                'unit_price' => $product->buy_price,
                'amount' => $amount
            ]);
            
            $product->increment('stock', $qty);
        } else {
            $request->validate([
                'description' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
                'expense_date' => 'required|date',
            ]);
            Expense::create($request->all());
        }
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);
        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diubah');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus');
    }
}
