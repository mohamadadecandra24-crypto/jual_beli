@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Pengeluaran</h2>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Catat Pengeluaran</a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
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

        <!-- Mobile Card View -->
        <div class="d-block d-md-none">
            @forelse($expenses as $expense)
            <div class="card mb-3 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-primary fw-bold">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</small>
                        <small class="text-muted">ID: {{ $loop->iteration }}</small>
                    </div>
                    
                    <h6 class="mb-2 fw-bold">{{ $expense->description }}</h6>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span><small class="text-muted">Qty:</small> {{ $expense->qty ? $expense->qty : '-' }}</span>
                        <span><small class="text-muted">@:</small> {{ $expense->unit_price ? 'Rp ' . number_format($expense->unit_price, 0, ',', '.') : '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <strong class="text-danger">Rp {{ number_format($expense->amount, 0, ',', '.') }}</strong>
                        <div class="d-flex gap-2">
                            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3">Belum ada catatan pengeluaran.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
