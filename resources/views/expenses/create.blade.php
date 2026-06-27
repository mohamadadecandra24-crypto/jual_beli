@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Catat Pengeluaran</h2>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="expense_date" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            
            <div class="mb-3">
                <label>Jenis Pengeluaran</label>
                <select name="expense_type" id="expense_type" class="form-select" onchange="toggleExpenseType()">
                    <option value="umum">Pengeluaran Umum (Listrik, ATK, dll)</option>
                    <option value="restock">Pembelian Stok Produk (Otomatis Tambah Stok)</option>
                </select>
            </div>
            
            <!-- Form Umum -->
            <div id="form-umum">
                <div class="mb-3">
                    <label>Keterangan</label>
                    <input type="text" name="description" id="umum_description" class="form-control" placeholder="Contoh: Bayar Listrik, ATK">
                </div>
                <div class="mb-3">
                    <label>Jumlah (Rp)</label>
                    <input type="number" name="amount" id="umum_amount" class="form-control" min="0">
                </div>
            </div>
            
            <!-- Form Restock -->
            <div id="form-restock" style="display: none;">
                <div class="mb-3">
                    <label>Pilih Produk</label>
                    <select name="product_id" id="product_id" class="form-select" onchange="calculateTotal()">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ intval($product->buy_price) }}">
                            {{ $product->name }} (Harga Beli: Rp {{ number_format($product->buy_price, 0, ',', '.') }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Jumlah Stok Dibeli (Qty)</label>
                    <input type="number" name="qty" id="qty" class="form-control" min="1" value="1" onkeyup="calculateTotal()" onchange="calculateTotal()">
                </div>
                <div class="mb-3">
                    <label>Total Biaya Pembelian (Rp)</label>
                    <input type="text" id="total_biaya" class="form-control" readonly value="0">
                </div>
                <small class="text-muted d-block mb-3">*Stok produk akan otomatis bertambah sesuai Qty, dan total biaya akan masuk ke pengeluaran.</small>
            </div>
            
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>
function toggleExpenseType() {
    let type = document.getElementById('expense_type').value;
    let formUmum = document.getElementById('form-umum');
    let formRestock = document.getElementById('form-restock');
    
    let uDesc = document.getElementById('umum_description');
    let uAmount = document.getElementById('umum_amount');
    let pId = document.getElementById('product_id');
    let pQty = document.getElementById('qty');

    if (type === 'umum') {
        formUmum.style.display = 'block';
        formRestock.style.display = 'none';
        
        uDesc.required = true;
        uAmount.required = true;
        pId.required = false;
        pQty.required = false;
    } else {
        formUmum.style.display = 'none';
        formRestock.style.display = 'block';
        
        uDesc.required = false;
        uAmount.required = false;
        pId.required = true;
        pQty.required = true;
    }
}

function calculateTotal() {
    let select = document.getElementById('product_id');
    let qty = parseInt(document.getElementById('qty').value) || 0;
    
    if (select.value) {
        let price = parseInt(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
        let total = price * qty;
        
        document.getElementById('total_biaya').value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
    } else {
        document.getElementById('total_biaya').value = '0';
    }
}

// Inisialisasi awal
toggleExpenseType();
</script>
@endsection
