@extends('layouts.app')

@section('title', config('app.name') . ' -- Tambah Alat')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header Halaman -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <h2 class="fw-bold mb-1">Tambah Alat</h2>
                <p class="text-muted small mb-0">Tambahkan inventaris alat baru ke dalam sistem.</p>
            </div>

            <!-- Card Pembungkus Form -->
            <div class="card border shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('alat.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_alat" class="form-label fw-semibold">Nama Alat</label>
                            <input type="text" name="nama_alat" id="nama_alat" class="form-control" value="{{ old('nama_alat') }}" placeholder="Contoh: Bor Listrik" required>
                        </div>

                        <div class="mb-3">
                            <label for="kode_alat" class="form-label fw-semibold">Kode Alat</label>
                            <input type="text" name="kode_alat" id="kode_alat" class="form-control" value="{{ old('kode_alat') }}" placeholder="Contoh: ALT-01" required>
                        </div>

                        <div class="mb-4">
                            <label for="id_kategori" class="form-label fw-semibold">Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary px-4">Kembali</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Alat</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection