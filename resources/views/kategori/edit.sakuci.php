@extends('layouts.app')

@section('title', config('app.name') . ' -- Edit Kategori')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header Halaman -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <h2 class="fw-bold mb-1">Edit Kategori</h2>
                <p class="text-muted small mb-0">Perbarui informasi data kategori inventaris.</p>
            </div>

            <!-- Card Pembungkus Form -->
            <div class="card border shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('kategori.update', ['id_kategori' => $kategori->id_kategori]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kode_kategori" class="form-label fw-semibold">Kode Kategori</label>
                            <input type="text" name="kode_kategori" id="kode_kategori" class="form-control" value="{{ $kategori->kode_kategori }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $kategori->keterangan }}" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary px-4">Kembali</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection