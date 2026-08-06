@extends('layouts.app')

@section('title', 'Daftar - Laundry Antar-Jemput')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-8 col-lg-7">
            <!-- Card dengan shadow lembut dan sudut melengkung -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header / Logo Area -->
                    <div class="text-center mb-4">
                        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 65px; height: 65px;">
                            <i class="bi bi-person-plus fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1">Daftar Akun Baru</h3>
                        <p class="text-muted small">Lengkapi data diri Anda di bawah ini</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row">
                            <!-- Input Nama -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
                                    <label for="name" class="text-muted"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Input Email -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                                    <label for="email" class="text-muted"><i class="bi bi-envelope me-2"></i>Email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Input Password -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" 
                                           id="password" name="password" placeholder="Password" required>
                                    <label for="password" class="text-muted"><i class="bi bi-lock me-2"></i>Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Input Konfirmasi Password -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control rounded-3" 
                                           id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                                    <label for="password_confirmation" class="text-muted"><i class="bi bi-shield-lock me-2"></i>Konfirmasi Password</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input Nomor Telepon -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3 @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="081234567890" required>
                            <label for="phone" class="text-muted"><i class="bi bi-telephone me-2"></i>Nomor Telepon</label>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Alamat Lengkap -->
                        <div class="form-floating mb-4">
                            <textarea class="form-control rounded-3 @error('address') is-invalid @enderror" 
                                      id="address" name="address" placeholder="Alamat Lengkap" style="height: 100px" required>{{ old('address') }}</textarea>
                            <label for="address" class="text-muted"><i class="bi bi-geo-alt me-2"></i>Alamat Lengkap</label>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Daftar -->
                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm">
                                Daftar Sekarang <i class="bi bi-person-check ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer Card -->
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <p class="mb-0 small text-muted">Sudah punya akun? 
                        <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection