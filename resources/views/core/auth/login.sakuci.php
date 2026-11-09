@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-6 col-lg-5">
            <!-- Card dengan latar belakang bernuansa ungu gelap (Glassmorphism) -->
            <div class="card border-0 shadow-lg text-light" style="background: rgba(35, 24, 58, 0.85); backdrop-filter: blur(12px); border-radius: 1rem; border: 1px solid rgba(124, 58, 237, 0.2) !important;">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header Form -->
                    <div class="text-center mb-4">
                        <span class="badge px-3 py-2 mb-2 rounded-pill" style="background: rgba(124, 58, 237, 0.25); color: #c4b5fd; font-size: 0.75rem; letter-spacing: 0.5px;">
                            SISTEM LAYANAN ALATSEKOLAH
                        </span>
                        <h1 class="h4 fw-bold mb-1">Masuk ke Akun</h1>
                        <p class="text-white-50 small">
                            Akun demo: <strong class="text-light">admin</strong> &mdash; password <code class="bg-dark px-1 py-0.5 rounded" style="color: #c4b5fd;">rahasia123</code>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf

                        <!-- Input Username -->
                        <div class="mb-3">
                            <label class="form-label small text-white-50" for="username">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-white-50 border-secondary border-end-0">
                                    👤
                                </span>
                                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                                    class="form-control bg-dark text-light border-secondary border-start-0 {{ errors()->has('username') ? 'is-invalid' : '' }}" 
                                    placeholder="Masukkan Username" autofocus>
                            </div>
                            @error('username') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Input Password -->
                        <div class="mb-4">
                            <label class="form-label small text-white-50" for="password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-white-50 border-secondary border-end-0">
                                    🔒
                                </span>
                                <input type="password" id="password" name="password" 
                                    class="form-control bg-dark text-light border-secondary border-start-0 {{ errors()->has('password') ? 'is-invalid' : '' }}" 
                                    placeholder="••••••••">
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Tombol Login dengan kode warna ungu #7c3aed -->
                        <button class="btn w-100 py-2 fw-semibold shadow-sm text-white" 
                            style="background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); border: none; border-radius: 0.5rem;" 
                            type="submit">
                            Masuk Sekarang
                        </button>
                    </form>

                    <!-- Cek Registrasi -->
                    @php
                        $canRegister = false;
                        try {
                            $canRegister = \App\Models\Role::where('can_register', 1)->exists();
                        } catch (\Throwable $e) {
                            $canRegister = false;
                        }
                    @endphp
                    @if ($canRegister)
                        <div class="text-center mt-4 pt-3 border-top border-secondary">
                            <p class="text-white-50 small mb-0">
                                Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #c4b5fd;">Daftar di sini</a>
                            </p>
                        </div>
                    @endif

                </div>
            </div>
            
            <!-- Footer kecil di bawah card -->
            <div class="text-center mt-3">
                <p class="text-white-50" style="font-size: 0.75rem;">&copy; 2026 Pengelolaan Alat & Fasilitas Sekolah</p>
            </div>
        </div>
    </div>
</div>

@endsection
