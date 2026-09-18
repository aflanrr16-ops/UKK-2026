@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')
<h1>Daftar alat</h1>
<a href="{{ route('alat.create') }}" class="btn btn-success mb-3">Tambah Alat</a>

<table class = "table table-sm align-middle"> 
<tr>
    <th>No</th>
    <th>nama alat</th>
    <th>kode alat</th>
    <th>Aksi</th>
</tr>
@php $no = 1; @endphp
@foreach ($datal as $alats)
<tr>
    <td> {{ $no++ }} </td>
    <td> {{ $alats->nama_alat }} </td>
    <td> {{ $alats->kode_alat }} </td>
    <td>
         <a href="{{ route('alat.edit', ['alat' => $alats->id_alat]) }}" class="btn btn-info btn-sm">Edit</a>
         <form action="{{ route('alat.delete', ['id' => $alats->id_alat]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">Hapus</button>
                        </form>
    </td>
</tr>
@endforeach
</table>
{!! $datal->links() !!}
@endsection