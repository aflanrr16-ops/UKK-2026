@extends('layouts.app')

@section('content')
<div class="container">
    <h1>TambahKategori </h1>
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">Nama kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
         
            <label for="nama">keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" required>

         <label for="nama">kode kategori</label>
            <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" required>
            
            
            

</div>
<button type="submit" class="btn btn-primary mt-3">Simpan </button>
</form>
</div>
@endsection