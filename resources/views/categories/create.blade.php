@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Tambah Kategori</h2>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
