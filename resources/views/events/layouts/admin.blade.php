<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jual Beli | @yield('title', 'Dashboard')</title>

    {{-- SB Admin 2 CSS & Bootstrap CDNs --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css">
    
    {{-- Custom CSS untuk reduce sidebar spacing --}}
    <style>
        body, html { font-family: 'Outfit', sans-serif !important; background-color: #f4f6f9; }
        .sidebar-dark { background-color: #1a1f36 !important; background-image: none !important; }
        @media (min-width: 768px) { .sidebar .nav-item .nav-link { padding: 0.75rem 1.5rem !important; color: #a1a5b7 !important; } }
        .sidebar .nav-item .nav-link:hover, .sidebar .nav-item.active .nav-link { color: #ffffff !important; background: rgba(255,255,255,0.05); }
        .sidebar .nav-item { margin-bottom: 0 !important; }
        .sidebar-brand { justify-content: flex-start !important; padding: 1.5rem !important; color: #fff !important; }
        .sidebar-brand-text { font-size: 1.25rem !important; font-weight: 700; color: #f59e0b; }
        .sidebar-brand-text span { color: #fff; }
        .sidebar.toggled .sidebar-brand { justify-content: center !important; }
        .sidebar-heading { font-size: 0.65rem !important; font-weight: 700; color: #64748b !important; padding: 1rem 1.5rem 0.5rem !important; text-transform: uppercase; }
        .topbar { box-shadow: none !important; border-bottom: 1px solid #e3e6f0; background: #fff !important; height: 70px; }
        .card { box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1) !important; border: none !important; border-radius: 0.5rem; }
        .table-responsive { border: 1px solid #e3e6f0; }
        .btn-outline-secondary { border-color: #e3e6f0; color: #64748b; font-weight: 500; }
        .btn-outline-secondary:hover { background-color: #f8f9fc; color: #3a3b45; }
        .user-info { text-align: right; line-height: 1.2; margin-right: 0.75rem; }
        .user-name { font-weight: 700; color: #3a3b45; font-size: 0.9rem; }
        .user-role { color: #858796; font-size: 0.75rem; }
    </style>
</head>

<body id="page-top">
<div id="wrapper">

    {{-- ===== SIDEBAR ===== --}}
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center" href="{{ url('/') }}">
            <div class="sidebar-brand-icon"><i class="fas fa-store" style="color: #f59e0b;"></i></div>
            <div class="sidebar-brand-text mx-3" style="color: #fff;"><span style="color: #f59e0b;">Jual</span>Beli</div>
        </a>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Manajemen</div>
        <li class="nav-item {{ request()->routeIs('dashboard') || request()->is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider mt-2">
        <div class="sidebar-heading">Barang-barang</div>
        <li class="nav-item {{ request()->routeIs('events.*') && !request()->is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('events.index') }}">
                <i class="fas fa-fw fa-box"></i><span>Produk</span>
            </a>
        </li>

        <hr class="sidebar-divider mt-2">
        <div class="sidebar-heading">Analitik</div>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-chart-bar"></i><span>Laporan</span>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>

    {{-- ===== CONTENT WRAPPER ===== --}}
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {{-- TOPBAR --}}
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top">
                <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                    <i class="fa fa-bars" style="color: #1a1f36; font-size: 1.2rem;"></i>
                </button>
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item mr-3">
                        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary btn-sm px-3 rounded-pill">
                            <i class="fas fa-external-link-alt mr-1"></i> Lihat Toko
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block mr-3"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                            <div class="user-info d-none d-lg-block">
                                <div class="user-name">Admin</div>
                                <div class="user-role">@kubik024</div>
                            </div>
                            <img class="img-profile rounded" src="https://ui-avatars.com/api/?name=kubik024&color=fff&background=1a1f36&rounded=false">
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- MAIN CONTENT --}}
            <div class="container-fluid">
                {{-- DYNAMIC CONTENT DARI BLADE LAIN --}}
                {{-- DYNAMIC CONTENT DARI BLADE LAIN --}}
                @yield('content')
            </div>
        </div>

        {{-- Footer --}}
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Jual Beli &copy; {{ date('Y') }} - Toko Digital</span>
                </div>
            </div>
        </footer>
    </div>
</div>

{{-- JS Scripts CDNs --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session("success") }}', showConfirmButton: false, timer: 2000 });
    @endif

    // Script konfirmasi hapus otomatis untuk tombol class .btn-delete
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Yakin hapus data?', text: "Data yang dihapus tidak bisa dikembalikan!", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#e74a3b', cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        })
    });
</script>
@yield('scripts')
</body>
</html>