@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kategori</h1>
    <form action="{{ route('kategori.update', ['kategori' => $kategori->id_kategori]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
            <label for="keterangan">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $kategori->keterangan }}" required> 
            <label for="kode">Kode kategori</label>
            <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" value="{{ $kategori->kode_kategori }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection