@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold"><i class="fas fa-cash-register text-primary"></i> Staf Administrasi Keuangan Toko</h2>
    <p class="text-muted">Kelola transaksi penjualan dengan mudah dan cepat.</p>
</div>

<div class="row g-4">
    <!-- Form Pilih Produk -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold"><i class="fas fa-box-open text-success me-2"></i> Pilih Produk</h5>
            </div>
            <div class="card-body">
                <form id="form-add-product">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label text-muted small fw-bold">Cari / Pilih Produk</label>
                            <select id="product_select" class="form-select" required>
                                <option value="">-- Ketik Nama Produk --</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    data-price="{{ $product->sell_price }}" 
                                    data-name="{{ $product->name }}" 
                                    data-stock="{{ $product->stock }}" 
                                    data-image="{{ $product->image ? Storage::url($product->image) : '' }}">
                                    {{ $product->name }} &mdash; Rp {{ number_format($product->sell_price, 0, ',', '.') }} (Stok: {{ $product->stock }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small fw-bold">Qty</label>
                            <input type="number" id="qty_input" class="form-control text-center" value="1" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Keranjang & Checkout -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-dark text-white pt-3 pb-3 rounded-top">
                <h5 class="fw-bold mb-0"><i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja</h5>
            </div>
            <div class="card-body d-flex flex-column">
                <form action="{{ route('transactions.store') }}" method="POST" id="form-checkout" class="flex-grow-1 d-flex flex-column">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Tanggal Transaksi</label>
                        <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="card bg-light border-0 mb-3 shadow-sm">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-3"><i class="fas fa-id-badge text-primary me-2"></i>Identitas Petugas</h6>
                            <div class="mb-2">
                                <label class="form-label text-muted small fw-bold mb-1">Nama Staf Administrasi</label>
                                <input type="text" name="cashier_name" class="form-control form-control-sm" placeholder="Nama lengkap staf" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-muted small fw-bold mb-1">NIP / ID Staf</label>
                                <input type="text" name="cashier_nip" class="form-control form-control-sm" placeholder="Nomor Induk Pegawai" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-muted small fw-bold mb-1">Nama Supervisor / Manajer</label>
                                <input type="text" name="supervisor_name" class="form-control form-control-sm" placeholder="Atasan penyetuju (opsional)">
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive flex-grow-1" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover align-middle" id="cart-table">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="50">Img</th>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Item Keranjang via JS -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-auto pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-muted mb-0">Total Tagihan</h5>
                            <h3 class="text-danger fw-bold mb-0" id="total-price-display">Rp 0</h3>
                        </div>
                        <div id="cart-inputs">
                            <!-- Hidden inputs via JS -->
                        </div>
                        <button type="button" class="btn btn-success btn-lg w-100 fw-bold" id="btn-checkout" disabled>
                            <i class="fas fa-check-circle me-2"></i> Selesaikan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Checkout -->
<div class="modal fade" id="confirmCheckoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-success text-white border-bottom-0">
        <h5 class="modal-title fw-bold"><i class="fas fa-question-circle me-2"></i> Konfirmasi Pembayaran</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4">
        <div class="mb-3">
            <i class="fas fa-cash-register fa-4x text-success opacity-75"></i>
        </div>
        <h5 class="fw-bold mb-3">Selesaikan Transaksi Ini?</h5>
        <p class="text-muted mb-0">Pastikan semua barang dan identitas staf sudah sesuai. Transaksi yang sudah diselesaikan tidak dapat dibatalkan.</p>
      </div>
      <div class="modal-footer border-top-0 d-flex justify-content-center pb-4">
        <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success px-4 fw-bold" id="btn-confirm-checkout">Ya, Selesaikan</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<!-- jQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let cart = [];

    $(document).ready(function() {
        $('#product_select').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Ketik Nama Produk --',
            allowClear: true
        });
    });

    document.getElementById('form-add-product').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let select = document.getElementById('product_select');
        let qty = parseInt(document.getElementById('qty_input').value);
        
        if(!select.value) return alert('Pilih produk dulu!');
        
        let id = select.value;
        let option = select.options[select.selectedIndex];
        let name = option.getAttribute('data-name');
        let price = parseInt(option.getAttribute('data-price'));
        let stock = parseInt(option.getAttribute('data-stock'));
        let image = option.getAttribute('data-image');
        
        let existing = cart.find(item => item.id == id);
        let newQty = existing ? existing.qty + qty : qty;
        
        if(newQty > stock) {
            return alert('Jumlah melebihi stok yang tersedia!');
        }

        if(existing) {
            existing.qty = newQty;
        } else {
            cart.push({ id, name, price, qty, image });
        }

        // Reset inputs
        $('#product_select').val(null).trigger('change');
        document.getElementById('qty_input').value = 1;
        
        renderCart();
    });

    function renderCart() {
        let tbody = document.querySelector('#cart-table tbody');
        let inputsDiv = document.getElementById('cart-inputs');
        let btnCheckout = document.getElementById('btn-checkout');
        
        tbody.innerHTML = '';
        inputsDiv.innerHTML = '';
        
        let total = 0;
        
        if(cart.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Keranjang kosong</td></tr>';
            document.getElementById('total-price-display').innerText = 'Rp 0';
            btnCheckout.disabled = true;
            return;
        }

        cart.forEach((item, index) => {
            let subtotal = item.price * item.qty;
            total += subtotal;
            
            let rpSubtotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(subtotal);
            let rpPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.price);
            
            let imgHtml = item.image ? `<img src="${item.image}" class="rounded" style="width:40px; height:40px; object-fit:cover;">` : `<div class="bg-secondary rounded text-white d-flex align-items-center justify-content-center" style="width:40px; height:40px; font-size:10px;">-</div>`;
            
            tbody.innerHTML += `
                <tr>
                    <td>${imgHtml}</td>
                    <td>
                        <div class="fw-bold">${item.name}</div>
                        <div class="text-muted small">${rpPrice}</div>
                    </td>
                    <td class="text-center fw-bold">${item.qty}</td>
                    <td class="text-end fw-bold">${rpSubtotal}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="removeItem(${index})" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            inputsDiv.innerHTML += `
                <input type="hidden" name="products[${index}][id]" value="${item.id}">
                <input type="hidden" name="products[${index}][quantity]" value="${item.qty}">
            `;
        });
        
        let rpTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
        document.getElementById('total-price-display').innerText = rpTotal;
        
        btnCheckout.disabled = cart.length === 0;
    }

    window.removeItem = function(index) {
        cart.splice(index, 1);
        renderCart();
    }

    document.getElementById('btn-checkout').addEventListener('click', function() {
        let checkoutModal = new bootstrap.Modal(document.getElementById('confirmCheckoutModal'));
        checkoutModal.show();
    });

    document.getElementById('btn-confirm-checkout').addEventListener('click', function() {
        document.getElementById('form-checkout').submit();
    });

    // Inisialisasi awal
    renderCart();
</script>
@endpush
