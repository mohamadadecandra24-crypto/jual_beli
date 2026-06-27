@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="Gambar" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px; font-size: 10px;">No Img</div>
                        @endif
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if($product->stock > 5)
                            {{ $product->stock }}
                        @else
                            <span class="badge bg-danger fs-6">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>
                    <td>
                        <!-- Tombol Tambah Stok (Restok) -->
                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#restockModal{{ $product->id }}" title="Tambah Stok">
                            <i class="fas fa-plus-circle"></i> Stok
                        </button>
                        
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Restok -->
                <div class="modal fade" id="restockModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('products.restock', $product) }}" method="POST">
                          @csrf
                          <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Tambah Stok: {{ $product->name }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>Harga Modal (Satuan): <strong>Rp {{ number_format($product->buy_price, 0, ',', '.') }}</strong></p>
                            <div class="mb-3">
                                <label>Jumlah Stok Ditambahkan (Qty)</label>
                                <input type="number" name="qty" id="restockQty{{ $product->id }}" class="form-control" value="1" min="1" required oninput="calcRestock{{ $product->id }}()">
                            </div>
                            <div class="mb-3">
                                <label>Total Biaya Pengeluaran</label>
                                <input type="text" id="restockTotal{{ $product->id }}" class="form-control" readonly value="Rp {{ number_format($product->buy_price, 0, ',', '.') }}">
                            </div>
                            <small class="text-muted">Total biaya otomatis masuk ke catatan <strong>Pengeluaran</strong>.</small>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan & Tambah Stok</button>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Script Hitung Interaktif Modal -->
                <script>
                    function calcRestock{{ $product->id }}() {
                        let qty = parseInt(document.getElementById('restockQty{{ $product->id }}').value) || 0;
                        let price = {{ intval($product->buy_price) }};
                        let total = qty * price;
                        document.getElementById('restockTotal{{ $product->id }}').value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
                    }
                </script>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
