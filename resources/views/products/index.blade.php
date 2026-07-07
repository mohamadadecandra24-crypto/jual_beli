@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
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
                            <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : Storage::url($product->image) }}" alt="Gambar" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
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
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <!-- Mobile Accordion View -->
        <div class="d-block d-md-none">
            <div class="accordion" id="accordionProducts">
                @forelse($products as $product)
                <div class="accordion-item mb-2 border-0 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingProduct{{ $product->id }}">
                        <button class="accordion-button collapsed rounded bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProduct{{ $product->id }}" aria-expanded="false" aria-controls="collapseProduct{{ $product->id }}">
                            <div class="d-flex align-items-center w-100 me-2">
                                @if($product->image)
                                    <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : Storage::url($product->image) }}" alt="Gambar" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;" class="me-3">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; border-radius: 4px; font-size: 10px;">No Img</div>
                                @endif
                                <div class="flex-grow-1 text-truncate">
                                    <h6 class="mb-0 fw-bold text-truncate">{{ $product->name }}</h6>
                                    <small class="text-muted">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</small>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseProduct{{ $product->id }}" class="accordion-collapse collapse" aria-labelledby="headingProduct{{ $product->id }}" data-bs-parent="#accordionProducts">
                        <div class="accordion-body bg-white border-top">
                            <p class="mb-1"><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
                            <p class="mb-2"><strong>Stok:</strong> 
                                @if($product->stock > 5)
                                    <span class="badge bg-secondary">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $product->stock }}</span>
                                @endif
                            </p>
                            
                            <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#restockModal{{ $product->id }}">
                                    <i class="fas fa-plus-circle"></i> Stok
                                </button>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3">Belum ada produk.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@foreach($products as $product)
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

<script>
    function calcRestock{{ $product->id }}() {
        let qty = parseInt(document.getElementById('restockQty{{ $product->id }}').value) || 0;
        let price = {{ intval($product->buy_price) }};
        let total = qty * price;
        document.getElementById('restockTotal{{ $product->id }}').value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
    }
</script>
@endforeach

    </div>
</div>
@endsection
