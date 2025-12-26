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
            --primary-blue-light: #3b82f6;
            --secondary-blue: #1e40af;
            --accent-blue: #60a5fa;
            --light-blue: #dbeafe;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-blue: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --gradient-card: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%) !important;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.3);
            border-bottom: none;
            padding: 1rem 0;
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.6rem;
            color: white !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand:hover {
            color: #dbeafe !important;
            transform: scale(1.05);
        }
        
        .navbar-brand .brand-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            margin: 0 4px;
            padding: 0.75rem 1.25rem !important;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .nav-link:hover::before {
            left: 100%;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.25) !important;
            color: white !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border-radius: 16px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            z-index: 9999 !important;
            position: absolute !important;
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            border-radius: 12px;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1e40af;
            transform: translateX(4px);
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e2e8f0;
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-toggler:hover {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        }
        
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .nav-item.dropdown .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            background: var(--gradient-card);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-large);
        }
        
        .stats-card {
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }
        
        .stats-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 12px;
            backdrop-filter: blur(10px);
        }
        
        .menu-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .menu-card:hover::before {
            transform: scaleX(1);
        }
        
        .menu-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-large);
        }
        
        .btn {
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background: var(--gradient-blue);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }
        
        .table {
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table thead th {
            background: var(--gradient-blue);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: var(--light-blue);
            transform: scale(1.01);
        }
        
        .badge {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }
        
        .page-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .welcome-text {
            color: #64748b;
            font-weight: 400;
        }
        
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        
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
        
        /* Alert Notifications */
        .alert {
            z-index: 1000 !important;
            position: relative;
            margin-bottom: 1rem;
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
                                <i class="bi bi-plus-circle"></i> Pesan Laundry
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}" href="{{ route('pelanggan.riwayat') }}">
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
                                <i class="bi bi-list-task"></i> Tugas Saya
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
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
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
    @yield('scripts')
</body>
</html>