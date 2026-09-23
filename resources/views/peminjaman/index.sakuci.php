@extends('layouts.app')

@section('title', config('app.name') . ' -- Daftar Peminjaman')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header Halaman & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Daftar Peminjaman Alat</h2>
            <p class="text-muted small mb-0">Kelola data peminjaman dan pengembalian alat inventaris.</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Peminjaman Baru
        </a>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Pembungkus Tabel -->
    <div class="card border shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-secondary text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3">Peminjam</th>
                            <th class="py-3">Nama Alat</th>
                            <th class="py-3">Jumlah</th>
                            <th class="py-3">Tgl Pinjam</th>
                            <th class="py-3">Tgl Kembali</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Denda</th>
                            <th class="py-3 text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($datap as $peminjaman)
                        <tr>
                            <td class="px-4 text-muted fw-semibold">{{ $no++ }}</td>
                            <td>
                                <span class="fw-bold">{{ $peminjaman->user->nama ?? 'User ID: ' . $peminjaman->id_user }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $peminjaman->alat->nama_alat ?? 'Alat ID: ' . $peminjaman->id_alat }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $peminjaman->jumlah }} Unit</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $peminjaman->tanggal_pinjam }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $peminjaman->tanggal_kembali ?? '-' }}</span>
                            </td>
                            <td>
                                @if($peminjaman->status == 'Pending')
                                    <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                @elseif($peminjaman->status == 'Disetujui')
                                    <span class="badge bg-info text-dark px-2 py-1">Disetujui</span>
                                @elseif($peminjaman->status == 'Ditolak')
                                    <span class="badge bg-danger px-2 py-1">Ditolak</span>
                                @elseif($peminjaman->status == 'Dipinjam')
                                    <span class="badge bg-primary px-2 py-1">Dipinjam</span>
                                @else
                                    <span class="badge bg-success px-2 py-1">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-danger fw-semibold">Rp {{ number_format($peminjaman->denda ?? 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('peminjaman.edit', ['id_peminjaman' => $peminjaman->id_peminjaman]) }}" class="btn btn-outline-warning btn-sm px-3">
                                        Edit
                                    </a>
                                    <form action="{{ route('peminjaman.delete', ['id_peminjaman' => $peminjaman->id_peminjaman]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-end" onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Belum ada data peminjaman alat yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Bagian Pagination di Bawah Card -->
        @if(method_exists($datap, 'hasPages') && $datap->hasPages())
        <div class="card-footer py-3 border-top d-flex justify-content-end">
            {!! $datap->links() !!}
        </div>
        @endif
    </div>

</div>
@endsection