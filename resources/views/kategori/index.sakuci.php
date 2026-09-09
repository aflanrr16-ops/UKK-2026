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
        <td><button class="btn btn-success">edit</button><button class="btn btn-danger">hapus</button></td>

</tr>
@endforeach
</tbody>
</table>
{!! $data->links() !!}
@endsection