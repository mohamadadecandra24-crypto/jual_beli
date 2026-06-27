<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function profitLoss(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Pendapatan & HPP
        $details = TransactionDetail::whereHas('transaction', function($q) use ($startDate, $endDate) {
            $q->whereBetween('transaction_date', [$startDate, $endDate]);
        })->get();

        $revenue = 0;
        $cogs = 0;

        foreach ($details as $detail) {
            $revenue += ($detail->sell_price * $detail->quantity);
            $cogs += ($detail->buy_price * $detail->quantity);
        }

        $grossProfit = $revenue - $cogs;

        // Pengeluaran
        $totalExpenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');

        $netProfit = $grossProfit - $totalExpenses;

        return view('reports.profit_loss', compact(
            'startDate', 'endDate', 'revenue', 'cogs', 'grossProfit', 'totalExpenses', 'netProfit'
        ));
    }
}
