@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Edit Produk</h2>
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
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Kategori</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <div class="mb-3">
                <label>Gambar Produk</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($product->image) }}" alt="Gambar Produk" style="max-height: 100px; border-radius: 5px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required min="0">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Harga Beli (Modal)</label>
                    <input type="number" name="buy_price" class="form-control" value="{{ intval($product->buy_price) }}" required min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Harga Jual</label>
                    <input type="number" name="sell_price" class="form-control" value="{{ intval($product->sell_price) }}" required min="0">
                </div>
            </div>
            <button class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
