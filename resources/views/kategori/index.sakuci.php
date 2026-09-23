@extends('layouts.app')

@section('title', config('app.name') . ' -- Daftar Kategori')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header Halaman & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Daftar Kategori</h2>
            <p class="text-muted small mb-0">Kelola kategori alat inventaris dengan mudah.</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori Baru
        </a>
    </div>

    <!-- Card Pembungkus Tabel -->
    <div class="card border shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-secondary text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3">Nama Kategori</th>
                            <th class="py-3">Kode Kategori</th>
                            <th class="py-3">Keterangan</th>
                            <th class="py-3 text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($data as $kategoris)
                        <tr>
                            <td class="px-4 text-muted fw-semibold">{{ $no++ }}</td>
                            <td>
                                <span class="fw-bold">{{ $kategoris->nama_kategori }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-20 border px-2 py-1 font-monospace">{{ $kategoris->kode_kategori }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $kategoris->keterangan ?? '-' }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kategori.edit', ['kategori' => $kategoris->id_kategori]) }}" class="btn btn-outline-warning btn-sm px-3">
                                        Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', ['id' => $kategoris->id_kategori]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-end" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data kategori yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Bagian Pagination di Bawah Card -->
        @if($data->hasPages())
        <div class="card-footer py-3 border-top d-flex justify-content-end">
            {!! $data->links() !!}
        </div>
        @endif
    </div>

</div>
@endsection