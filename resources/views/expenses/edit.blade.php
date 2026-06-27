@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Edit Pengeluaran</h2>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="expense_date" class="form-control" required value="{{ \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') }}">
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <input type="text" name="description" class="form-control" required value="{{ $expense->description }}">
            </div>
            <div class="mb-3">
                <label>Jumlah (Rp)</label>
                <input type="number" name="amount" class="form-control" required min="0" value="{{ intval($expense->amount) }}">
            </div>
            <button class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
