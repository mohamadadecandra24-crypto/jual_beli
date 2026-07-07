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

        <!-- Mobile Accordion View -->
        <div class="d-block d-md-none">
            <div class="accordion" id="accordionExpenses">
                @forelse($expenses as $expense)
                <div class="accordion-item mb-2 border-0 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingExp{{ $loop->iteration }}">
                        <button class="accordion-button collapsed rounded bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExp{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapseExp{{ $loop->iteration }}">
                            <div class="d-flex flex-column w-100 me-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-primary fw-bold">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</small>
                                    <strong class="text-danger">Rp {{ number_format($expense->amount, 0, ',', '.') }}</strong>
                                </div>
                                <h6 class="mb-0 fw-bold text-truncate">{{ $expense->description }}</h6>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseExp{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="headingExp{{ $loop->iteration }}" data-bs-parent="#accordionExpenses">
                        <div class="accordion-body bg-white border-top">
                            <div class="d-flex justify-content-between mb-2">
                                <span><small class="text-muted">Qty:</small> {{ $expense->qty ? $expense->qty : '-' }}</span>
                                <span><small class="text-muted">@:</small> {{ $expense->unit_price ? 'Rp ' . number_format($expense->unit_price, 0, ',', '.') : '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-2 pt-2 border-top">
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
</div>
@endsection
