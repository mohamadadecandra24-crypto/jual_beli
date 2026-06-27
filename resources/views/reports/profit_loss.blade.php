@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Laporan Laba Rugi</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('reports.profit_loss') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-auto">
                <label>Dari Tanggal:</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-auto">
                <label>Sampai Tanggal:</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-auto mt-4">
                <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Pendapatan & HPP -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                Rincian Penjualan (Laba Kotor)
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Total Pendapatan Kotor</td>
                        <td class="text-end">Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Total Harga Pokok (Modal)</td>
                        <td class="text-end text-danger">- Rp {{ number_format($cogs, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>Laba Kotor</td>
                        <td class="text-end">Rp {{ number_format($grossProfit, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Pengeluaran Operasional -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark">
                Rincian Pengeluaran Operasional
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Total Pengeluaran</td>
                        <td class="text-end text-danger">- Rp {{ number_format($totalExpenses, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Laba Bersih -->
<div class="card border-primary mb-4">
    <div class="card-body text-center">
        <h4 class="text-muted">Total Laba Bersih</h4>
        <h1 class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
            Rp {{ number_format($netProfit, 0, ',', '.') }}
        </h1>
        <p class="mb-0 text-muted">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>
</div>
@endsection
