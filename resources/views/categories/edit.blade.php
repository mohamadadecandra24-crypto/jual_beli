@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Edit Kategori</h2>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>
            <button class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
