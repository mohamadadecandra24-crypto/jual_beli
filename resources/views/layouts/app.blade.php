<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Jual Beli</title>
    <!-- Favicon -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/875/875565.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; }
        .sidebar a { color: #fff; text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover { background-color: rgba(255,255,255,0.1); }
        .content { padding: 20px; }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-md-row min-vh-100">
        <!-- Mobile Navbar -->
        <nav class="navbar navbar-dark bg-primary d-md-none px-3 sticky-top shadow-sm">
            <a class="navbar-brand" href="#"><i class="fas fa-store"></i> JualBeli App</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>

        <!-- Sidebar / Offcanvas -->
        <div class="offcanvas-md offcanvas-start bg-primary sidebar p-3" tabindex="-1" id="sidebarOffcanvas" style="width: 250px;">
            <div class="d-flex justify-content-between align-items-center mb-4 d-md-none">
                <h5 class="text-white m-0"><i class="fas fa-store"></i> Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas"></button>
            </div>
            <h4 class="text-white text-center mb-4 d-none d-md-block"><i class="fas fa-store"></i> JualBeli App</h4>
            
            <a href="{{ route('transactions.create') }}"><i class="fas fa-cash-register me-2"></i> Admin Kasir</a>
            <a href="{{ route('transactions.index') }}"><i class="fas fa-receipt me-2"></i> Riwayat Transaksi</a>
            <hr class="text-white opacity-50">
            <a href="{{ route('products.index') }}"><i class="fas fa-box me-2"></i> Produk</a>
            <a href="{{ route('categories.index') }}"><i class="fas fa-tags me-2"></i> Kategori</a>
            <a href="{{ route('expenses.index') }}"><i class="fas fa-wallet me-2"></i> Pengeluaran</a>
            <hr class="text-white opacity-50">
            <a href="{{ route('reports.profit_loss') }}"><i class="fas fa-chart-line me-2"></i> Laporan Laba Rugi</a>
        </div>

        <!-- Main Content -->
        <div class="content flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.form-delete');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
    </script>
    @stack('scripts')
</body>
</html>
