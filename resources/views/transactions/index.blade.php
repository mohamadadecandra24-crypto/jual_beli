@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold"><i class="fas fa-receipt text-primary"></i> Riwayat Transaksi</h2>
        <p class="text-muted">Lihat semua riwayat penjualan yang telah berhasil.</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Kasir Baru</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Staf Administrasi</th>
                    <th>Total Pembayaran</th>
                    <th width="150" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge bg-secondary">#INV-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td>
                        <i class="far fa-calendar-alt text-muted me-1"></i> 
                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                    </td>
                    <td>
                        <i class="fas fa-user-circle text-muted me-1"></i>
                        {{ $transaction->cashier_name ?? 'Tanpa Nama Staf' }}
                    </td>
                    <td>
                        <strong class="text-success">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-receipt fa-3x text-muted mb-3 opacity-50"></i>
                        <p class="text-muted mb-0">Belum ada riwayat transaksi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
