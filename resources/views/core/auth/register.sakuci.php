@extends('layouts.app')

@section('title', 'Daftar')

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
                        <h1 class="h4 fw-bold mb-1">Daftar Akun Baru</h1>
                        <p class="text-white-50 small mb-0">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: #c4b5fd;">Masuk di sini</a>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register.attempt') }}">
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
                                    placeholder="Pilih username Anda" autofocus>
                            </div>
                            @error('username') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
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

                        <!-- Konfirmasi Password -->
                        <div class="mb-3">
                            <label class="form-label small text-white-50" for="password_confirmation">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-white-50 border-secondary border-end-0">
                                    🔒
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                    class="form-control bg-dark text-light border-secondary border-start-0" 
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Pilihan Role / Daftar Sebagai -->
                        @if (count($roles) > 1)
                            <div class="mb-4">
                                <label class="form-label small text-white-50" for="role">Daftar sebagai</label>
                                <select id="role" name="role" class="form-select bg-dark text-light border-secondary {{ errors()->has('role') ? 'is-invalid' : '' }}">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        @else
                            <input type="hidden" name="role" value="{{ $roles[0]->name }}">
                        @endif

                        <!-- Tombol Daftar dengan gradasi warna ungu #7c3aed -->
                        <button class="btn w-100 py-2 fw-semibold shadow-sm text-white" 
                            style="background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); border: none; border-radius: 0.5rem;" 
                            type="submit">
                            Daftar Sekarang
                        </button>
                    </form>
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
