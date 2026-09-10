@extends('layouts.app')
@section('content')
<h1>kategori</h1>
<a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
<table class="table table-stripe table-hover">
<thead>
    <tr>
        <th >no</th>
        <th >Kode Kategori</th>
        <th >Nama Kategori</th>
        <th >Keterangan</th>
        <th >aksi</th>
</tr>
</thead>
<tbody>
    @php $no = 1;@endphp
    @foreach ($data as $item)
    <tr>
        <td>{{ $no++}}</td>
        <td>{{ $item->kode_kategori }}</td>
        <td>{{ $item->nama_kategori }}</td>
        <td>{{ $item->keterangan }}</td>
        <td>
            <a href="{{ route('admin.kategori.edit', ['kategori' => $item->id_kategori]) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('kategori.destroy', ['kategori' => $item->id_kategori]) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
            </form>
</tr>
@endforeach
</tbody>
</table>
{!! $data->links() !!}
@endsection