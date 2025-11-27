@extends('layouts.app')

@section('title', 'Login - Laundry Antar-Jemput')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="bi bi-box-arrow-in-right"></i> Login</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </div>
                </form>

                <hr>
                <div class="text-center">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                </div>

                <!-- Info Login -->
                <div class="mt-4">
                    <h6>Info Login:</h6>
                    <small class="text-muted">
                        <strong>Admin:</strong> admin@laundry.com / password<br>
                        <strong>Pelanggan:</strong> pelanggan@laundry.com / password<br>
                        <strong>Kurir:</strong> kurir@laundry.com / password
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection