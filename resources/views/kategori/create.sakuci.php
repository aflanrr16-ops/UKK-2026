@extends('layouts.app')

@section('content')
<div class="container">
    <h1>TambahKategori </h1>
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">Nama kategori</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
</div>
<button type="submit" class="btn btn-primary mt-3">Simpan </button>
</form>
</div>
@endsection