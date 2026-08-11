<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'JasaLaundry')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-dark: #1d4ed8;
            --gradient-blue: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            margin: 0;
        }

        /* =========================================
           NAVBAR
        ========================================= */

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

        .brand-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        /* =========================================
           DROPDOWN
        ========================================= */

        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            background: white;
            padding: 0.4rem;
        }

        .dropdown-item {
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
            border-radius: 6px;
            margin: 2px 0;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
        }

        /* =========================================
           MOBILE NAVBAR
        ========================================= */

        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 6px;
            padding: 0.3rem 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* =========================================
           USER
        ========================================= */

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
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 0.15rem 0.35rem;
            font-size: 0.65rem;
            min-width: 18px;
            text-align: center;
            margin-left: 6px;
        }

        /* =========================================
           MAIN CONTENT
        ========================================= */

        main {
            min-height: calc(100vh - 150px);
        }

        /* =========================================
           CARD
        ========================================= */

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            background: white;
        }

        /* =========================================
           BUTTON
        ========================================= */

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--gradient-blue);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        }

        /* =========================================
           TABLE
        ========================================= */

        .table thead th {
            background: var(--gradient-blue);
            color: white;
            border: none;
        }

        /* =========================================
           BADGE
        ========================================= */

        .badge {
            border-radius: 6px;
            font-weight: 500;
        }

        /* =========================================
           ALERT
        ========================================= */

        .alert {
            border-radius: 8px;
            border: none;
        }

        /* =========================================
           FOOTER
        ========================================= */

        .main-footer {
            background: linear-gradient(
                135deg,
                #667eea 0%,
                #764ba2 100%
            );
            margin-top: auto;
        }

        /* =========================================
           LOGIN PAGE
           Kalau halaman login memberi class login-page
        ========================================= */

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .login-page .login-card {
            width: 100%;
            max-width: 430px;
        }

        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 1200px) {
            .nav-link {
                padding: 0.5rem 0.8rem !important;
                font-size: 0.95rem;
            }

            .navbar-brand {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 991.98px) {

            .navbar-collapse {
                background: rgba(30, 64, 175, 0.98);
                border-radius: 10px;
                margin-top: 0.5rem;
                padding: 1rem;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            }

            .navbar-nav .nav-link {
                padding: 0.8rem 1rem !important;
                margin: 0.2rem 0;
                width: 100%;
                text-align: left;
            }

            .dropdown-menu {
                position: static !important;
                background: rgba(255, 255, 255, 0.12);
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

        @media (max-width: 768px) {

            .card-body {
                padding: 1rem 0.75rem;
            }

            h1,
            h2 {
                font-size: 1.5rem;
            }

            h3,
            h4 {
                font-size: 1.25rem;
            }

            .main-footer p {
                font-size: 11px !important;
            }
        }
    </style>
</head>

<body>

    {{-- =====================================================
         NAVBAR
         HANYA MUNCUL JIKA USER SUDAH LOGIN
    ====================================================== --}}

    @auth

        <nav class="navbar navbar-expand-lg navbar-dark">

            <div class="container">

                {{-- BRAND --}}
                <a class="navbar-brand"
                   href="{{ auth()->user()->role === 'admin'
                        ? route('admin.dashboard')
                        : (auth()->user()->role === 'pelanggan'
                            ? route('pelanggan.dashboard')
                            : route('kurir.dashboard')) }}">

                    <div class="brand-icon">
                        <i class="bi bi-droplet-half"></i>
                    </div>

                    JasaLaundry

                </a>


                {{-- MOBILE TOGGLE --}}
                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav"
                        aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>


                <div class="collapse navbar-collapse" id="navbarNav">

                    {{-- =====================================================
                         MENU UTAMA
                    ====================================================== --}}

                    <ul class="navbar-nav me-auto">

                        {{-- ================= PELANGGAN ================= --}}

                        @if(auth()->user()->role === 'pelanggan')

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}"
                                   href="{{ route('pelanggan.dashboard') }}">

                                    <i class="bi bi-house me-1"></i>
                                    Beranda

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pelanggan.order') ? 'active' : '' }}"
                                   href="{{ route('pelanggan.order') }}">

                                    <i class="bi bi-plus-circle me-1"></i>
                                    Pesan

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') && request()->get('tab') === 'pesanan' ? 'active' : '' }}"
                                   href="{{ route('pelanggan.riwayat', ['tab' => 'pesanan']) }}">

                                    <i class="bi bi-box-seam me-1"></i>
                                    Pesanan Saya

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') && request()->get('tab') === 'riwayat' ? 'active' : '' }}"
                                   href="{{ route('pelanggan.riwayat', ['tab' => 'riwayat']) }}">

                                    <i class="bi bi-clock-history me-1"></i>
                                    Riwayat

                                </a>
                            </li>


                        {{-- ================= KURIR ================= --}}

                        @elseif(auth()->user()->role === 'kurir')

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('kurir.dashboard') ? 'active' : '' }}"
                                   href="{{ route('kurir.dashboard') }}">

                                    <i class="bi bi-speedometer2 me-1"></i>
                                    Dashboard

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('kurir.tugas') ? 'active' : '' }}"
                                   href="{{ route('kurir.tugas') }}">

                                    <i class="bi bi-list-task me-1"></i>
                                    Tugas

                                </a>
                            </li>


                        {{-- ================= ADMIN ================= --}}

                        @elseif(auth()->user()->role === 'admin')

                            {{-- Dashboard --}}
                            <li class="nav-item">

                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                   href="{{ route('admin.dashboard') }}">

                                    <i class="bi bi-speedometer2 me-1"></i>
                                    Dashboard

                                </a>

                            </li>


                            {{-- Kelola Data --}}
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle
                                    {{ request()->routeIs('admin.paket.*') ||
                                       request()->routeIs('admin.promo.*') ||
                                       request()->routeIs('admin.outlet.*') ||
                                       request()->routeIs('admin.promo-claim.*')
                                       ? 'active' : '' }}"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">

                                    <i class="bi bi-gear me-1"></i>
                                    Kelola Data

                                </a>

                                <ul class="dropdown-menu">

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.paket.index') }}">

                                            <i class="bi bi-box text-primary me-2"></i>
                                            Kelola Paket

                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.outlet.index') }}">

                                            <i class="bi bi-shop text-info me-2"></i>
                                            Kelola Outlet

                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.promo.index') }}">

                                            <i class="bi bi-gift text-success me-2"></i>
                                            Kelola Promo

                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.promo-claim.index') }}">

                                            <i class="bi bi-check-circle text-warning me-2"></i>
                                            Validasi Promo

                                            @php
                                                $pendingClaims = \App\Models\PromoClaim::where(
                                                    'status',
                                                    'pending'
                                                )->count();
                                            @endphp

                                            @if($pendingClaims > 0)
                                                <span class="badge bg-danger ms-2">
                                                    {{ $pendingClaims }}
                                                </span>
                                            @endif

                                        </a>
                                    </li>

                                </ul>

                            </li>


                            {{-- Kelola Operasional --}}
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle
                                    {{ request()->routeIs('admin.transaksi.*') ||
                                       request()->routeIs('admin.kurir.*')
                                       ? 'active' : '' }}"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">

                                    <i class="bi bi-people me-1"></i>
                                    Kelola Operasional

                                </a>

                                <ul class="dropdown-menu">

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.transaksi.index') }}">

                                            <i class="bi bi-receipt text-info me-2"></i>
                                            Kelola Transaksi

                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.kurir.index') }}">

                                            <i class="bi bi-truck text-primary me-2"></i>
                                            Kelola Kurir

                                        </a>
                                    </li>

                                </ul>

                            </li>


                            {{-- Laporan --}}
                            <li class="nav-item">

                                <a class="nav-link {{ request()->routeIs('admin.riwayat.*') ? 'active' : '' }}"
                                   href="{{ route('admin.riwayat.index') }}">

                                    <i class="bi bi-bar-chart me-1"></i>
                                    Laporan

                                </a>

                            </li>

                        @endif

                    </ul>


                    {{-- =====================================================
                         USER MENU
                    ====================================================== --}}

                    <ul class="navbar-nav">

                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle d-flex align-items-center"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">

                                <div class="user-avatar me-2">
                                    <i class="bi bi-person-circle"></i>
                                </div>

                                <span class="d-lg-inline">
                                    {{ auth()->user()->name }}
                                </span>

                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <h6 class="dropdown-header">

                                        <i class="bi bi-person-badge me-1"></i>

                                        {{ ucfirst(auth()->user()->role) }}

                                    </h6>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>

                                    <form action="{{ route('logout') }}"
                                          method="POST">

                                        @csrf

                                        <button type="submit"
                                                class="dropdown-item text-danger">

                                            <i class="bi bi-box-arrow-right me-2"></i>
                                            Logout

                                        </button>

                                    </form>

                                </li>

                            </ul>

                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    @endauth


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="{{ auth()->check() ? 'py-4' : '' }}">

        <div class="{{ auth()->check() ? 'container' : '' }}">

            {{-- SUCCESS --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show"
                     role="alert">

                    <i class="bi bi-check-circle me-1"></i>

                    {{ session('success') }}

                    @auth
                        @if(session('whatsapp_url') && auth()->user()->role === 'admin')

                            <br>

                            <a href="{{ session('whatsapp_url') }}"
                               target="_blank"
                               class="btn btn-success btn-sm mt-2">

                                <i class="bi bi-whatsapp me-1"></i>
                                Kirim Notifikasi WhatsApp

                            </a>

                        @endif
                    @endauth

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- ERROR --}}
            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show"
                     role="alert">

                    <i class="bi bi-exclamation-triangle me-1"></i>

                    {{ session('error') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- INFO --}}
            @if(session('info'))

                <div class="alert alert-info alert-dismissible fade show"
                     role="alert">

                    <i class="bi bi-info-circle me-1"></i>

                    {{ session('info') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- PAGE CONTENT --}}
            @yield('content')

        </div>

    </main>


    {{-- =====================================================
         FOOTER
         TIDAK MUNCUL DI LOGIN
    ====================================================== --}}

    @auth

        <footer class="main-footer py-3">

            <div class="container text-center text-white">

                <p class="mb-0 small">
                    &copy; {{ date('Y') }} JasaLaundry. Semua hak dilindungi.
                </p>

            </div>

        </footer>

    @endauth


    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    {{-- Mobile Navbar --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const navbarCollapse =
                document.querySelector('.navbar-collapse');

            if (!navbarCollapse) {
                return;
            }

            const navLinks =
                navbarCollapse.querySelectorAll(
                    '.nav-link:not(.dropdown-toggle)'
                );

            navLinks.forEach(function (link) {

                link.addEventListener('click', function () {

                    if (
                        window.innerWidth < 992 &&
                        navbarCollapse.classList.contains('show')
                    ) {

                        const bsCollapse =
                            bootstrap.Collapse.getInstance(navbarCollapse);

                        if (bsCollapse) {
                            bsCollapse.hide();
                        }

                    }

                });

            });

        });

    </script>


    @yield('scripts')

</body>
</html>