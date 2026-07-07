<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function login(Request $request)
    {
        if ($request->username === 'ade' && $request->password === 'Ad123can!') {
            $request->session()->put('report_auth', true);
            return redirect()->route('reports.profit_loss');
        }
        return back()->with('error', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('report_auth');
        return redirect()->route('reports.profit_loss');
    }

    public function profitLoss(Request $request)
    {
        if (!$request->session()->get('report_auth')) {
            return view('reports.login');
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $diffDays = $start->diffInDays($end) + 1;

        $prevEndDate = $start->copy()->subDay();
        $prevStartDate = $prevEndDate->copy()->subDays($diffDays - 1);

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

        // Previous Period Calculations
        $prevDetails = TransactionDetail::whereHas('transaction', function($q) use ($prevStartDate, $prevEndDate) {
            $q->whereBetween('transaction_date', [$prevStartDate->toDateString(), $prevEndDate->toDateString()]);
        })->get();

        $prevRevenue = 0;
        $prevCogs = 0;
        foreach ($prevDetails as $detail) {
            $prevRevenue += ($detail->sell_price * $detail->quantity);
            $prevCogs += ($detail->buy_price * $detail->quantity);
        }
        $prevGrossProfit = $prevRevenue - $prevCogs;
        $prevTotalExpenses = Expense::whereBetween('expense_date', [$prevStartDate->toDateString(), $prevEndDate->toDateString()])->sum('amount');
        
        $prevNetProfit = $prevGrossProfit - $prevTotalExpenses;

        return view('reports.profit_loss', compact(
            'startDate', 'endDate', 'revenue', 'cogs', 'grossProfit', 'totalExpenses', 'netProfit',
            'prevStartDate', 'prevEndDate', 'prevNetProfit'
        ));
    }
}
