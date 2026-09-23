@extends('layouts.app')

@section('title', config('app.name') . ' -- Daftar Alat')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header Halaman & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <!-- Menggunakan text-body agar otomatis menyesuaikan mode (hitam di terang, putih/terang di gelap) -->
            <h2 class="fw-bold mb-1">Daftar Alat</h2>
            <p class="text-muted small mb-0">Kelola data inventaris alat peminjaman dengan mudah.</p>
        </div>
        <a href="{{ route('alat.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Alat Baru
        </a>
    </div>

    <!-- Card Pembungkus Tabel (Menggunakan bg-body dan border standar agar otomatis berubah warna saat dark mode) -->
    <div class="card border shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Tambahkan kelas table-striped atau biarkan standar, pastikan tidak memaksa teks jadi hitam pekat -->
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-secondary text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3">Nama Alat</th>
                            <th class="py-3">Kode Alat</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3 text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($datal as $alats)
                        <tr>
                            <td class="px-4 text-muted fw-semibold">{{ $no++ }}</td>
                            <td>
                                <!-- Menggunakan kelas bawaan teks agar kontras dengan mode gelap -->
                                <span class="fw-bold">{{ $alats->nama_alat }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-20 border px-2 py-1 font-monospace">{{ $alats->kode_alat }}</span>
                            </td>
                            <td>
                                @php
                                    $namaKategori = '-';
                                    foreach ($kategori as $k) {
                                        if ($k->id_kategori == $alats->id_kategori) {
                                            $namaKategori = $k->nama_kategori;
                                            break;
                                        }
                                    }
                                @endphp
                                <span class="badge bg-info bg-opacity-10 text-info fw-semibold px-2 py-1">
                                    {{ $namaKategori }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('alat.edit', ['alat' => $alats->id_alat]) }}" class="btn btn-outline-warning btn-sm px-3">
                                        Edit
                                    </a>
                                    <form action="{{ route('alat.delete', ['id' => $alats->id_alat]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-end" onclick="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data alat yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Bagian Pagination di Bawah Card -->
        @if($datal->hasPages())
        <div class="card-footer py-3 border-top d-flex justify-content-end">
            {!! $datal->links() !!}
        </div>
        @endif
    </div>

</div>
@endsection