@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Tambah Produk</h2>
    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Link Gambar Produk (URL)</label>
                <input type="url" name="image" class="form-control" placeholder="https://contoh.com/gambar.jpg">
                <small class="text-muted">Masukkan link URL gambar dari internet. Kosongkan jika tidak ada.</small>
            </div>
            <div class="mb-3">
                <label>Stok Awal</label>
                <input type="number" name="stock" class="form-control" value="0" required min="0">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Harga Beli (Modal)</label>
                    <input type="number" name="buy_price" class="form-control" required min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Harga Jual</label>
                    <input type="number" name="sell_price" class="form-control" required min="0">
                </div>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
