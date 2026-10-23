@extends('layouts.app')

@section('title', config('app.name') . ' -- Tambah Kategori')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Header Halaman & Tombol Kembali -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-body d-flex align-items-center gap-2">
                        <i class="bi bi-tags" style="color: #A855F7;"></i> Tambah Kategori
                    </h2>
                    <p class="text-secondary small mb-0">Tambahkan kelompok inventaris baru ke dalam sistem.</p>
                </div>
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-3 px-3 shadow-sm btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <!-- Card Tunggal Modern Ala Form Terpadu -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-body modern-form-container">
                
                <!-- Garis Aksen Gradien Ungu (#A855F7) -->
                <div class="card-top-accent" style="height: 6px; background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%);"></div>

                <!-- Header di Dalam Card -->
                <div class="card-header bg-transparent border-bottom border-secondary-subtle pt-4 pb-3 px-4 px-md-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon-box flex-shrink-0 shadow-sm" style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                            <i class="bi bi-plus-circle-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-body">Tambah Kategori Baru</h5>
                            <span class="text-secondary small">Tambahkan kelompok inventaris baru ke sistem</span>
                        </div>
                    </div>
                </div>

                <!-- Body Form -->
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold text-body fs-7">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-secondary-subtle text-secondary">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" name="nama_kategori" id="nama_kategori" 
                                       class="form-control bg-body-tertiary border-secondary-subtle text-body py-2.5 px-3 rounded-end-3 shadow-none" 
                                       value="{{ old('nama_kategori') }}" 
                                       placeholder="Contoh: Kordofon" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="kode_kategori" class="form-label fw-semibold text-body fs-7">
                                Kode Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-secondary-subtle text-secondary">
                                    <i class="bi bi-qr-code"></i>
                                </span>
                                <input type="text" name="kode_kategori" id="kode_kategori" 
                                       class="form-control bg-body-tertiary border-secondary-subtle text-body py-2.5 px-3 rounded-end-3 shadow-none" 
                                       value="{{ old('kode_kategori') }}" 
                                       placeholder="Contoh: K-01" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-semibold text-body fs-7">
                                Keterangan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-secondary-subtle text-secondary">
                                    <i class="bi bi-card-text"></i>
                                </span>
                                <input type="text" name="keterangan" id="keterangan" 
                                       class="form-control bg-body-tertiary border-secondary-subtle text-body py-2.5 px-3 rounded-end-3 shadow-none" 
                                       value="{{ old('keterangan') }}" 
                                       placeholder="Masukkan keterangan tambahan" required>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary-subtle">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-3 fw-medium fs-7 d-inline-flex align-items-center gap-1.5">
                                <i class="bi bi-x-circle me-1"></i>
                                <span>Batal</span>
                            </a>
                            
                            <button type="submit" class="btn px-4 py-2.5 rounded-3 fw-bold fs-7 shadow-sm d-inline-flex align-items-center gap-1.5 text-white"
                                    style="background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%); border: none;">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                <span>Simpan Kategori</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

</div>

<!-- 🎨 CUSTOM STYLESHEET -->
<style>
    .modern-form-container {
        border: 1px solid var(--bs-border-color-translucent) !important;
    }

    .form-control:focus, .form-select:focus {
        border-color: #A855F7 !important;
        box-shadow: 0 0 0 0.25rem rgba(168, 85, 247, 0.15) !important;
    }

    .fs-7 { font-size: 0.875rem; }
</style>
@endsection
