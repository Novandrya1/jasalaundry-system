<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JasaLaundry')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-dark: #1d4ed8;
            --gradient-blue: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        
        /* Navbar Styles */
        .navbar {
            background: var(--gradient-blue) !important;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.3);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand .brand-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 10px;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            margin: 0 4px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            background: white;
        }
        
        .dropdown-item {
            padding: 0.5rem 0.8rem;
            font-size: 0.9rem;
            border-radius: 4px;
            margin: 2px;
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 6px;
            padding: 0.3rem 0.5rem;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .user-avatar {
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .badge-notification {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 0.1rem 0.3rem;
            font-size: 0.6rem;
            min-width: 16px;
        }
        
        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .nav-link {
                padding: 0.5rem 0.8rem !important;
                font-size: 0.95rem;
            }
            .navbar-brand {
                font-size: 1.4rem;
            }
        }
        
        @media (max-width: 992px) {
            .navbar-collapse {
                background: rgba(30, 64, 175, 0.98);
                border-radius: 8px;
                margin-top: 0.5rem;
                padding: 1rem;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            }
            
            .navbar-nav .nav-link {
                padding: 0.8rem 1rem !important;
                margin: 0.3rem 0;
                width: 100%;
                text-align: left;
                font-size: 1rem;
            }
            
            .dropdown-menu {
                position: static !important;
                background: rgba(255, 255, 255, 0.15);
                box-shadow: none;
                margin: 0.3rem 0;
            }
            
            .dropdown-item {
                color: rgba(255, 255, 255, 0.9);
            }
            
            .dropdown-item:hover {
                background: rgba(255, 255, 255, 0.2);
                color: white;
            }
        }
        
        /* Card and other styles */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            background: white;
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-primary {
            background: var(--gradient-blue);
        }
        
        .table thead th {
            background: var(--gradient-blue);
            color: white;
            border: none;
        }
        
        .badge {
            border-radius: 6px;
            font-weight: 500;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem 0.75rem;
            }
            h1, h2 {
                font-size: 1.5rem;
            }
            h3, h4 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'pelanggan' ? route('pelanggan.dashboard') : route('kurir.dashboard'))) : route('login') }}">
                <div class="brand-icon">
                    <i class="bi bi-droplet-half"></i>
                </div>
                JasaLaundry
            </a>
            
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role === 'pelanggan')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}" href="{{ route('pelanggan.dashboard') }}">
                                <i class="bi bi-house"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pelanggan.order') ? 'active' : '' }}" href="{{ route('pelanggan.order') }}">
                                <i class="bi bi-plus-circle"></i> Pesan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') && request()->get('tab') === 'pesanan' ? 'active' : '' }}" href="{{ route('pelanggan.riwayat', ['tab' => 'pesanan']) }}">
                                <i class="bi bi-box-seam"></i> Pesanan Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') && request()->get('tab') === 'riwayat' ? 'active' : '' }}" href="{{ route('pelanggan.riwayat', ['tab' => 'riwayat']) }}">
                                <i class="bi bi-clock-history"></i> Riwayat
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'kurir')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kurir.dashboard') ? 'active' : '' }}" href="{{ route('kurir.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kurir.tugas') ? 'active' : '' }}" href="{{ route('kurir.tugas') }}">
                                <i class="bi bi-list-task"></i> Tugas
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.paket.*') || request()->routeIs('admin.promo.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i> Kelola Data
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.paket.index') }}">
                                    <i class="bi bi-box text-primary"></i> Kelola Paket
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.promo.index') }}">
                                    <i class="bi bi-gift text-success"></i> Kelola Promo
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.promo-claim.index') }}">
                                    <i class="bi bi-check-circle text-warning"></i> Validasi Promo
                                    @php
                                        $pendingClaims = \App\Models\PromoClaim::where('status', 'pending')->count();
                                    @endphp
                                    @if($pendingClaims > 0)
                                        <span class="badge-notification">{{ $pendingClaims }}</span>
                                    @endif
                                </a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.transaksi.*') || request()->routeIs('admin.kurir.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-people"></i> Kelola Operasional
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.transaksi.index') }}">
                                    <i class="bi bi-receipt text-info"></i> Kelola Transaksi
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.kurir.index') }}">
                                    <i class="bi bi-truck text-primary"></i> Kelola Kurir
                                </a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.riwayat.*') ? 'active' : '' }}" href="{{ route('admin.riwayat.index') }}">
                                <i class="bi bi-bar-chart"></i> Laporan
                            </a>
                        </li>
                    @endif
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">
                                <i class="bi bi-person-badge"></i> {{ ucfirst(auth()->user()->role) }}
                            </h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
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
            <p class="mb-0">&copy; 2025 JasaLaundry. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar mobile functionality
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            // Close navbar when clicking nav links on mobile
            if (navbarCollapse) {
                const navLinks = navbarCollapse.querySelectorAll('.nav-link:not(.dropdown-toggle)');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                            if (bsCollapse) {
                                bsCollapse.hide();
                            }
                        }
                    });
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>