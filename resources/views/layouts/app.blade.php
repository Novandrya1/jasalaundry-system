<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JasaLaundry')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Mobile Responsive Fixes */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }
            .btn-group .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            .card-body {
                padding: 1rem 0.75rem;
            }
            .navbar-nav .nav-link {
                padding: 0.5rem 1rem;
            }
            .badge {
                font-size: 0.7rem;
            }
            h1, h2 {
                font-size: 1.5rem;
            }
            h3, h4 {
                font-size: 1.25rem;
            }
            h5 {
                font-size: 1.1rem;
            }
        }
        
        /* Table Mobile Optimization */
        @media (max-width: 576px) {
            .table-responsive table {
                font-size: 0.75rem;
            }
            .table-responsive th,
            .table-responsive td {
                padding: 0.25rem;
                vertical-align: middle;
            }
            .btn-sm {
                padding: 0.125rem 0.25rem;
                font-size: 0.7rem;
            }
        }
        
        /* Card Mobile Optimization */
        .mobile-card {
            margin-bottom: 1rem;
        }
        
        @media (max-width: 576px) {
            .mobile-card .card-body {
                padding: 0.75rem;
            }
            .mobile-stack {
                display: block !important;
            }
            .mobile-stack > * {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-droplet-half"></i> JasaLaundry
            </a>
            
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role === 'pelanggan')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pelanggan.dashboard') }}">
                                <i class="bi bi-house"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pelanggan.order') }}">
                                <i class="bi bi-plus-circle"></i> Pesan Laundry
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pelanggan.riwayat') }}">
                                <i class="bi bi-clock-history"></i> Riwayat
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'kurir')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kurir.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kurir.tugas') }}">
                                <i class="bi bi-list-task"></i> Tugas Saya
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.paket.index') }}">
                                <i class="bi bi-box"></i> Kelola Paket
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
                                <i class="bi bi-receipt"></i> Kelola Transaksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.kurir.index') }}">
                                <i class="bi bi-people"></i> Kelola Kurir
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.promo.index') }}">
                                <i class="bi bi-gift"></i> Kelola Promo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.promo-claim.index') }}">
                                <i class="bi bi-check-circle"></i> Validasi Promo
                                @php
                                    $pendingClaims = \App\Models\PromoClaim::where('status', 'pending')->count();
                                @endphp
                                @if($pendingClaims > 0)
                                    <span class="badge bg-danger">{{ $pendingClaims }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.riwayat.index') }}">
                                <i class="bi bi-clock-history"></i> Riwayat & Laporan
                            </a>
                        </li>
                    @endif
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    @if(session('whatsapp_url') && auth()->user()->role === 'admin')
                        <br><a href="{{ session('whatsapp_url') }}" target="_blank" class="btn btn-success btn-sm mt-2">
                            <i class="bi bi-whatsapp"></i> Kirim Notifikasi WhatsApp
                        </a>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 JasaLaundry. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>