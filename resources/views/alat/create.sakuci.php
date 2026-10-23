@extends('layouts.app')

@section('title', config('app.name') . ' -- Tambah Alat')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <!-- Header Halaman & Tombol Kembali -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-body d-flex align-items-center gap-2">
                        <i class="bi bi-tools" style="color: #A855F7;"></i> Tambah Alat
                    </h2>
                    <p class="text-secondary small mb-0">Tambahkan alat baru ke dalam sistem peminjaman.</p>
                </div>
                <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary rounded-3 px-3 shadow-sm btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <!-- Card Utama Form -->
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <!-- BARIS 25: Aksen Garis Gradien Ungu (#A855F7) -->
                <div style="height: 6px; background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%);"></div>

                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header Kartu Internal -->
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-secondary-subtle">
                        <!-- BARIS 31: Kotak Ikon Header Ungu (#A855F7) -->
                        <div class="rounded-3 text-white d-flex align-items-center justify-content-center shadow-sm" 
                             style="background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%); width: 48px; height: 48px; flex-shrink: 0;">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-body">Formulir Tambah Alat</h5>
                            <span class="text-secondary small">Isi rincian informasi data alat baru di bawah ini</span>
                        </div>
                    </div>

                    <form action="{{ route('alat.store') }}" method="POST">
                        @csrf

                        <!-- Nama Alat Field -->
                        <div class="mb-4">
                            <label for="nama_alat" class="form-label fw-semibold text-body">
                                Nama Alat <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-secondary-subtle text-secondary">
                                    <i class="bi bi-box-seam"></i>
                                </span>
                                <input type="text" name="nama_alat" id="nama_alat" 
                                       class="form-control bg-body-tertiary border-secondary-subtle text-body py-2" 
                                       value="{{ old('nama_alat') }}" 
                                       placeholder="Contoh: Proyektor Epson EB-X400" required>
                            </div>
                        </div>

                        <!-- Grid 2 Kolom untuk Kode Alat dan Kategori -->
                        <div class="row g-3 mb-4">
                            <!-- Kode Alat Field -->
                            <div class="col-md-6">
                                <label for="kode_alat" class="form-label fw-semibold text-body">
                                    Kode Alat <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-secondary-subtle text-secondary">
                                        <i class="bi bi-qr-code"></i>
                                    </span>
                                    <input type="text" name="kode_alat" id="kode_alat" 
                                           class="form-control bg-body-tertiary border-secondary-subtle text-body py-2" 
                                           value="{{ old('kode_alat') }}" 
                                           placeholder="Contoh: ALT-01" required>
                                </div>
                            </div>

                            <!-- Kategori Dropdown Field -->
                            <div class="col-md-6">
                                <label for="id_kategori" class="form-label fw-semibold text-body">
                                    Kategori <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-secondary-subtle text-secondary">
                                        <i class="bi bi-tags"></i>
                                    </span>
                                    <select name="id_kategori" id="id_kategori" 
                                            class="form-select bg-body-tertiary border-secondary-subtle text-body py-2" required>
                                        <option value="" class="text-body">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id_kategori }}" class="text-body" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top border-secondary-subtle">
                            <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            <!-- BARIS 99: Tombol Simpan Ungu (#A855F7) -->
                            <button type="submit" class="btn text-white px-4 py-2 rounded-3 fw-bold shadow-sm" 
                                    style="background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%); border: none;">
                                <i class="bi bi-check-circle-fill me-1"></i> Simpan Alat
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
