<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->orderBy('transaction_date', 'desc')->orderBy('id', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total_amount = 0;
            
            // Create transaction first
            $transaction = Transaction::create([
                'user_id' => null, 
                'transaction_date' => $request->transaction_date,
                'total_amount' => 0, // Akan diupdate nanti
                'cashier_name' => $request->cashier_name,
                'cashier_nip' => $request->cashier_nip,
                'supervisor_name' => $request->supervisor_name,
            ]);

            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['id']);
                $quantity = $item['quantity'];

                if ($product->stock < $quantity) {
                    throw new \Exception("Stok {$product->name} tidak cukup.");
                }

                $subtotal = $product->sell_price * $quantity;
                $total_amount += $subtotal;

                // Create detail
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'sell_price' => $product->sell_price,
                    'buy_price' => $product->buy_price,
                ]);

                // Reduce stock
                $product->stock -= $quantity;
                $product->save();
            }

            $transaction->update(['total_amount' => $total_amount]);

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');
        return view('transactions.show', compact('transaction'));
    }
}
