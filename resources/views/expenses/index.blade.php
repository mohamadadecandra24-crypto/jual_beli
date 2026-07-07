@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Pengeluaran</h2>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Catat Pengeluaran</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Stok (Qty)</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah (Total)</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->qty ? $expense->qty : '-' }}</td>
                    <td>{{ $expense->unit_price ? 'Rp ' . number_format($expense->unit_price, 0, ',', '.') : '-' }}</td>
                    <td><strong>Rp {{ number_format($expense->amount, 0, ',', '.') }}</strong></td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada catatan pengeluaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
