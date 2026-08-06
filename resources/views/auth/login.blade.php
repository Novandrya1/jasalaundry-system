@extends('layouts.app')

@section('title', 'Login - Laundry Antar-Jemput')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-5 col-lg-4">
            <!-- Card dengan border dihilangkan, shadow lembut, dan sudut melengkung -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header / Logo Area -->
                    <div class="text-center mb-4">
                        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 65px; height: 65px;">
                            <!-- Ikon air/mesin cuci untuk tema laundry -->
                            <i class="bi bi-droplet-half fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1">Selamat Datang</h3>
                        <p class="text-muted small">Silakan login ke akun Anda</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Floating Label untuk Email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                            <label for="email" class="text-muted"><i class="bi bi-envelope me-2"></i>Alamat Email</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Floating Label untuk Password -->
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Password" required>
                            <label for="password" class="text-muted"><i class="bi bi-lock me-2"></i>Kata Sandi</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Opsi Ingat Saya & Lupa Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4 small">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none fw-semibold">Lupa Password?</a>
                            @endif
                        </div>

                        <!-- Tombol Login -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm">
                                Masuk <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Footer Card -->
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <p class="mb-0 small text-muted">Belum punya akun? 
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection