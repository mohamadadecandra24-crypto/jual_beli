@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Detail Transaksi #{{ $transaction->id }}</h2>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</p>
        <p><strong>Nama Staf Administrasi (Kasir):</strong> {{ $transaction->cashier_name ?? '-' }}</p>
        <p><strong>NIP / ID Staf:</strong> {{ $transaction->cashier_nip ?? '-' }}</p>
        <p><strong>Nama Supervisor / Manajer:</strong> {{ $transaction->supervisor_name ?? '-' }}</p>
        <p><strong>Total Pembayaran:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Rincian Barang
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga Jual (saat itu)</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product->name ?? 'Produk Dihapus' }}</td>
                    <td>Rp {{ number_format($detail->sell_price, 0, ',', '.') }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($detail->sell_price * $detail->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
