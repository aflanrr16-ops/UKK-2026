@extends('layouts.app')

@section('title', config('app.name') . ' -- Daftar Alat')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <!-- Hero Banner Header -->
    <div class="card border-0 rounded-4 overflow-hidden mb-4 shadow-lg text-white" 
         style="background: linear-gradient(135deg, #17153b 0%, #0f0c20 100%); position: relative; border: 1px solid rgba(168, 85, 247, 0.2) !important;">
        
        <!-- Hiasan Ikon Kotak / Inventaris 3D (Sisi Kanan) -->
        <div class="d-none d-md-flex position-absolute align-items-center justify-content-center" 
             style="right: 50px; top: 50%; transform: translateY(-50%); width: 80px; height: 80px; background: rgba(168, 85, 247, 0.15); border-radius: 50%; border: 1px solid rgba(168, 85, 247, 0.3); box-shadow: 0 0 30px rgba(168, 85, 247, 0.25);">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 8L12 3L3 8V16L12 21L21 16V8Z" stroke="#a855f7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 3V12" stroke="#a855f7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 8L12 12L3 8" stroke="#a855f7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="card-body p-4 p-md-5 position-relative z-1">
            <span class="badge rounded-pill px-3 py-1.5 mb-3 fw-semibold small text-uppercase tracking-wider"
                  style="background: rgba(168, 85, 247, 0.15); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.3);">
                <i class="bi bi-tools me-1"></i> Manajemen Peminjaman Alat Sekolah
            </span>
            
            <h2 class="fw-bold mb-2 display-6">Daftar Alat</h2>
            <p class="text-white-50 mb-4 col-lg-7" style="font-size: 0.95rem;">
                Kelola data peminjaman alat sekolah dengan mudah, cepat, dan terorganisir.
            </p>

            <a href="{{ route('alat.create') }}" class="btn px-4 py-2.5 rounded-3 fw-medium shadow-sm d-inline-flex align-items-center gap-2"
               style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: white; border: none;">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Alat Baru</span>
            </a>
        </div>
    </div>

    <!-- Card Data Tabel Alat -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--bs-border-color-translucent) !important;">
        <!-- Header Card -->
        <div class="card-header bg-body border-bottom py-3 px-4">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-1" style="width: 12px; height: 12px; background-color: #a855f7;"></div>
                <h6 class="card-title mb-0 fw-semibold text-body-emphasis">Data Alat</h6>
            </div>
            <p class="text-secondary small mb-0 ms-3 mt-1">Daftar seluruh alat yang tersedia.</p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary border-bottom text-secondary text-uppercase small tracking-wider">
                        <tr>
                            <th class="py-3 px-4 text-center" style="width: 5%;">NO</th>
                            <th class="py-3 px-3">KODE ALAT</th>
                            <th class="py-3 px-3">NAMA ALAT</th>
                            <th class="py-3 px-3">KATEGORI</th>
                            <th class="py-3 px-4 text-center" style="width: 180px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = method_exists($datal, 'firstItem') ? $datal->firstItem() : 1;
                        @endphp

                        @forelse ($datal as $alats)
                        <tr>
                            <!-- NO -->
                            <td class="px-4 text-center text-secondary fw-medium small">
                                {{ $no++ }}
                            </td>
                            
                            <!-- KODE ALAT -->
                            <td class="px-3">
                                <span class="badge font-monospace fw-semibold px-2.5 py-1.5 rounded-2 small"
                                      style="background: rgba(124, 58, 237, 0.1); color: #818cf8; border: 1px solid rgba(124, 58, 237, 0.2);">
                                    {{ $alats->kode_alat }}
                                </span>
                            </td>

                            <!-- NAMA ALAT -->
                            <td class="px-3">
                                <div class="fw-bold text-body-emphasis small text-uppercase">{{ $alats->nama_alat }}</div>
                            </td>

                            <!-- KATEGORI -->
                            <td class="px-3">
                                @php
                                    $namaKategori = '-';
                                    foreach ($kategori as $k) {
                                        if ($k->id_kategori == $alats->id_kategori) {
                                            $namaKategori = $k->nama_kategori;
                                            break;
                                        }
                                    }
                                @endphp
                                <span class="text-secondary small">{{ $namaKategori }}</span>
                            </td>

                            <!-- AKSI -->
                            <td class="px-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('alat.edit', ['alat' => $alats->id_alat]) }}" 
                                       class="btn btn-sm px-2.5 py-1 rounded-2 fw-medium small d-inline-flex align-items-center gap-1.5" 
                                       title="Edit"
                                       style="color: #a855f7; background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2);">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('alat.delete', ['id' => $alats->id_alat]) }}" 
                                          method="POST" 
                                          class="d-inline m-0" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" 
                                                class="btn btn-sm px-2.5 py-1 rounded-2 fw-medium small d-inline-flex align-items-center gap-1.5" 
                                                title="Delete"
                                                style="color: #ec4899; background: rgba(236, 72, 153, 0.1); border: 1px solid rgba(236, 72, 153, 0.2);">
                                            <i class="bi bi-trash3"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-inbox fs-1" style="color: #a855f7; opacity: 0.5;"></i>
                                    <span class="small fw-medium">Belum ada data alat yang ditambahkan.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Bagian Pagination -->
        @if(method_exists($datal, 'hasPages') && $datal->hasPages())
        <div class="card-footer bg-body border-top py-3 px-4 d-flex justify-content-between align-items-center">
            <div class="small text-secondary">
                Menampilkan {{ $datal->firstItem() }} sampai {{ $datal->lastItem() }} dari {{ $datal->total() }} data
            </div>
            <div class="pagination-purple">
                {!! $datal->links() !!}
            </div>
        </div>
        @endif
    </div>

</div>

{{-- Styling Tambahan --}}
<style>
    .pagination-purple .page-item.active .page-link {
        background-color: #7c3aed;
        border-color: #7c3aed;
    }
    .pagination-purple .page-link {
        color: #a855f7;
    }
    .pagination-purple .page-link:hover {
        background-color: rgba(168, 85, 247, 0.1);
        color: #7c3aed;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(168, 85, 247, 0.04);
    }
</style>
@endsection
