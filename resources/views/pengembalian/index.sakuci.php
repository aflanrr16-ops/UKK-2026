@extends('layouts.app')

@section('title', config('app.name') . ' -- Data Pengembalian')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <!-- Flash Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Banner Header -->
    <div class="card border-0 rounded-4 overflow-hidden mb-4 shadow-lg text-white" 
         style="background: linear-gradient(135deg, #17153b 0%, #0f0c20 100%); position: relative; border: 1px solid rgba(168, 85, 247, 0.2) !important;">
        
        <!-- Hiasan Ikon Pengembalian 3D (Sisi Kanan) -->
        <div class="d-none d-md-flex position-absolute align-items-center justify-content-center" 
             style="right: 50px; top: 50%; transform: translateY(-50%); width: 80px; height: 80px; background: rgba(168, 85, 247, 0.15); border-radius: 50%; border: 1px solid rgba(168, 85, 247, 0.3); box-shadow: 0 0 30px rgba(168, 85, 247, 0.25);">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                <path d="M3 3v5h5"/>
            </svg>
        </div>

        <div class="card-body p-4 p-md-5 position-relative z-1">
            <span class="badge rounded-pill px-3 py-1.5 mb-3 fw-semibold small text-uppercase tracking-wider"
                  style="background: rgba(168, 85, 247, 0.15); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.3);">
                <i class="bi bi-arrow-down-left-circle me-1"></i> Transaksi Pengembalian
            </span>
            
            <h2 class="fw-bold mb-2 display-6">Data Pengembalian</h2>
            <p class="text-white-50 mb-4 col-lg-7" style="font-size: 0.95rem;">
                Kelola riwayat pengembalian barang, kondisi alat, dan denda keterlambatan dengan mudah.
            </p>

            <a href="{{ route('pengembalian.create') }}" class="btn px-4 py-2.5 rounded-3 fw-medium shadow-sm d-inline-flex align-items-center gap-2"
               style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: white; border: none;">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Pengembalian</span>
            </a>
        </div>
    </div>

    <!-- Card Data Tabel Pengembalian -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--bs-border-color-translucent) !important;">
        <!-- Header Card -->
        <div class="card-header bg-body border-bottom py-3 px-4">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-1" style="width: 12px; height: 12px; background-color: #a855f7;"></div>
                <h6 class="card-title mb-0 fw-semibold text-body-emphasis">Data Pengembalian</h6>
            </div>
            <p class="text-secondary small mb-0 ms-3 mt-1">Daftar seluruh riwayat pengembalian alat dan kondisinya.</p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary border-bottom text-secondary text-uppercase small tracking-wider">
                        <tr>
                            <th class="py-3 px-4 text-center" style="width: 5%;">NO</th>
                            <th class="py-3 px-3">PEMINJAM & ALAT</th>
                            <th class="py-3 px-3">TGL PENGEMBALIAN</th>
                            <th class="py-3 px-3">TERLAMBAT</th>
                            <th class="py-3 px-3">DENDA</th>
                            <th class="py-3 px-3">KONDISI BARANG</th>
                            <th class="py-3 px-3">CATATAN</th>
                            <th class="py-3 px-4 text-center" style="width: 180px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = method_exists($datap, 'firstItem') ? $datap->firstItem() : 1;
                        @endphp

                        @forelse($datap as $index => $d)
                            @php
                                $p = $peminjamanList[$d->id_peminjaman] ?? null;
                                $uname = $p ? ($userList[$p->id_user] ?? '-') : '-';
                                $alatName = $p ? ($alatList[$p->id_alat] ?? '-') : '-';

                                $kondisi = $d->kondisi_barang ?? 'Baik';
                                $badgeKondisi = match($kondisi) {
                                    'Baik' => 'bg-success-subtle text-success-emphasis border border-success-subtle',
                                    'Rusak Ringan' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                                    'Rusak Berat', 'Hilang' => 'bg-danger-subtle text-danger-emphasis border border-danger-subtle',
                                    default => 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle'
                                };
                            @endphp
                            <tr>
                                <!-- NO -->
                                <td class="px-4 text-center text-secondary fw-medium small">
                                    {{ method_exists($datap, 'firstItem') ? $no++ : $index + 1 }}
                                </td>
                                
                                <!-- PEMINJAM & ALAT -->
                                <td class="px-3">
                                    <div class="fw-bold text-body-emphasis small text-uppercase">{{ $uname }}</div>
                                    <div class="small text-secondary mt-0.5">
                                        {{ $alatName }} 
                                        <span class="badge rounded-pill font-monospace ms-1"
                                              style="background: rgba(124, 58, 237, 0.1); color: #818cf8; border: 1px solid rgba(124, 58, 237, 0.2);">
                                            #{{ $d->id_peminjaman }}
                                        </span>
                                    </div>
                                </td>

                                <!-- TGL PENGEMBALIAN -->
                                <td class="px-3">
                                    <span class="text-secondary small">{{ $d->tanggal_pengembalian }}</span>
                                </td>

                                <!-- TERLAMBAT -->
                                <td class="px-3">
                                    @if($d->terlambat_hari > 0)
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle rounded-2 px-2.5 py-1.5 small fw-semibold">
                                            {{ $d->terlambat_hari }} Hari
                                        </span>
                                    @else
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle rounded-2 px-2.5 py-1.5 small fw-semibold">
                                            Tepat Waktu
                                        </span>
                                    @endif
                                </td>

                                <!-- DENDA -->
                                <td class="px-3">
                                    <span class="text-danger fw-semibold small">Rp {{ number_format($d->denda ?? 0, 0, ',', '.') }}</span>
                                </td>

                                <!-- KONDISI BARANG -->
                                <td class="px-3">
                                    <span class="badge {{ $badgeKondisi }} px-2.5 py-1.5 rounded-2 small fw-semibold">
                                        {{ $kondisi }}
                                    </span>
                                </td>

                                <!-- CATATAN -->
                                <td class="px-3">
                                    <span class="text-secondary small">{{ $d->catatan ?? '-' }}</span>
                                </td>

                                <!-- AKSI -->
                                <td class="px-4 text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('pengembalian.edit', [$d->id_pengembalian]) }}" 
                                           class="btn btn-sm px-2.5 py-1 rounded-2 fw-medium small d-inline-flex align-items-center gap-1.5" 
                                           title="Edit"
                                           style="color: #a855f7; background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2);">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('pengembalian.delete', [$d->id_pengembalian]) }}" 
                                              method="POST" 
                                              class="d-inline m-0" 
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
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
                                <td colspan="8" class="text-center py-5 text-secondary">
                                    <div class="d-flex flex-column align-items-center gap-2">
                                        <i class="bi bi-inbox fs-1" style="color: #a855f7; opacity: 0.5;"></i>
                                        <span class="small fw-medium">Belum ada data pengembalian.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bagian Pagination -->
        @if(method_exists($datap, 'hasPages') && $datap->hasPages())
        <div class="card-footer bg-body border-top py-3 px-4 d-flex justify-content-between align-items-center">
            <div class="small text-secondary">
                Menampilkan {{ $datap->firstItem() }} sampai {{ $datap->lastItem() }} dari {{ $datap->total() }} data
            </div>
            <div class="pagination-purple">
                {!! $datap->links() !!}
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
