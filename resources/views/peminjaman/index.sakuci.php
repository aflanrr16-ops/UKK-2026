@extends('layouts.app')

@section('title', config('app.name') . ' -- Daftar Peminjaman')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <!-- Hero Banner Header -->
    <div class="card border-0 rounded-4 overflow-hidden mb-4 shadow-lg text-white" 
         style="background: linear-gradient(135deg, #17153b 0%, #0f0c20 100%); position: relative; border: 1px solid rgba(168, 85, 247, 0.2) !important;">
        
        <!-- Hiasan Ikon Kotak / Inventaris 3D (Sisi Kanan) -->
        <div class="d-none d-md-flex position-absolute align-items-center justify-content-center" 
             style="right: 50px; top: 50%; transform: translateY(-50%); width: 80px; height: 80px; background: rgba(168, 85, 247, 0.15); border-radius: 50%; border: 1px solid rgba(168, 85, 247, 0.3); box-shadow: 0 0 30px rgba(168, 85, 247, 0.25);">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 8L12 3L3 8V16L12 21L21 16V8Z"/>
                <path d="M12 3V12"/>
                <path d="M21 8L12 12L3 8"/>
            </svg>
        </div>

        <div class="card-body p-4 p-md-5 position-relative z-1">
            <span class="badge rounded-pill px-3 py-1.5 mb-3 fw-semibold small text-uppercase tracking-wider"
                  style="background: rgba(168, 85, 247, 0.15); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.3);">
                <i class="bi bi-arrow-up-right-circle me-1"></i> Transaksi Peminjaman
            </span>
            
            <h2 class="fw-bold mb-2 display-6">Daftar Peminjaman Alat</h2>
            <p class="text-white-50 mb-4 col-lg-7" style="font-size: 0.95rem;">
                Kelola dan pantau data peminjaman serta pengembalian alat secara menyeluruh.
            </p>

            <a href="{{ route('peminjaman.create') }}" class="btn px-4 py-2.5 rounded-3 fw-medium shadow-sm d-inline-flex align-items-center gap-2"
               style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: white; border: none;">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Peminjaman Baru</span>
            </a>
        </div>
    </div>

    <!-- Card Data Tabel Peminjaman -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--bs-border-color-translucent) !important;">
        <!-- Header Card -->
        <div class="card-header bg-body border-bottom py-3 px-4">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-1" style="width: 12px; height: 12px; background-color: #a855f7;"></div>
                <h6 class="card-title mb-0 fw-semibold text-body-emphasis">Data Peminjaman</h6>
            </div>
            <p class="text-secondary small mb-0 ms-3 mt-1">Daftar riwayat dan status peminjaman alat inventaris.</p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary border-bottom text-secondary text-uppercase small tracking-wider">
                        <tr>
                            <th class="py-3 px-4 text-center" style="width: 5%;">NO</th>
                            <th class="py-3 px-3">PEMINJAM</th>
                            <th class="py-3 px-3">NAMA ALAT</th>
                            <th class="py-3 px-3">JUMLAH</th>
                            <th class="py-3 px-3">TGL PINJAM</th>
                            <th class="py-3 px-3">TGL KEMBALI</th>
                            <th class="py-3 px-3">STATUS</th>
                            <th class="py-3 px-3">DENDA</th>
                            <th class="py-3 px-4 text-center" style="width: 180px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = method_exists($datap, 'firstItem') ? $datap->firstItem() : 1;
                        @endphp

                        @forelse ($datap as $peminjaman)
                        @php
                            $userIdVal = $peminjaman->id_user ?? $peminjaman->user_id ?? null;
                            $userObj = $peminjaman->user ?? ($userIdVal ? \App\Models\User::find($userIdVal) : null);
                            $namaUserFinal = $userObj->name ?? $userObj->nama ?? $userObj->username ?? $userObj->email ?? ($userIdVal ? 'User #' . $userIdVal : 'Tanpa Nama');

                            $alatIdVal = $peminjaman->id_alat ?? $peminjaman->alat_id ?? null;
                            $alatObj = $peminjaman->alat ?? ($alatIdVal ? \App\Models\Alat::find($alatIdVal) : null);
                            $namaAlatFinal = $alatObj->nama_alat ?? $alatObj->nama ?? $alatObj->name ?? ($alatIdVal ? 'Alat #' . $alatIdVal : 'Alat Tidak Diketahui');
                        @endphp
                        <tr>
                            <!-- NO -->
                            <td class="px-4 text-center text-secondary fw-medium small">
                                {{ $no++ }}
                            </td>
                            
                            <!-- PEMINJAM -->
                            <td class="px-3">
                                <div class="fw-bold text-body-emphasis small text-uppercase">{{ $namaUserFinal }}</div>
                            </td>

                            <!-- NAMA ALAT -->
                            <td class="px-3">
                                <div class="fw-semibold text-body-emphasis small">{{ $namaAlatFinal }}</div>
                            </td>

                            <!-- JUMLAH -->
                            <td class="px-3">
                                <span class="badge font-monospace fw-semibold px-2.5 py-1.5 rounded-2 small"
                                      style="background: rgba(124, 58, 237, 0.1); color: #818cf8; border: 1px solid rgba(124, 58, 237, 0.2);">
                                    {{ $peminjaman->jumlah }} Unit
                                </span>
                            </td>

                            <!-- TGL PINJAM -->
                            <td class="px-3">
                                <span class="text-secondary small">{{ $peminjaman->tanggal_pinjam }}</span>
                            </td>

                            <!-- TGL KEMBALI -->
                            <td class="px-3">
                                <span class="text-secondary small">{{ $peminjaman->tanggal_kembali ?? '-' }}</span>
                            </td>

                            <!-- STATUS -->
                            <td class="px-3">
                                @if($peminjaman->status == 'Pending')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-semibold px-2.5 py-1.5 rounded-2 small">Pending</span>
                                @elseif($peminjaman->status == 'Disetujui')
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fw-semibold px-2.5 py-1.5 rounded-2 small">Disetujui</span>
                                @elseif($peminjaman->status == 'Ditolak')
                                    <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle fw-semibold px-2.5 py-1.5 rounded-2 small">Ditolak</span>
                                @elseif($peminjaman->status == 'Dipinjam')
                                    <span class="badge fw-semibold px-2.5 py-1.5 rounded-2 small"
                                          style="background: rgba(168, 85, 247, 0.1); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.2);">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle fw-semibold px-2.5 py-1.5 rounded-2 small">Dikembalikan</span>
                                @endif
                            </td>

                            <!-- DENDA -->
                            <td class="px-3">
                                <span class="text-danger fw-semibold small">Rp {{ number_format($peminjaman->denda ?? 0, 0, ',', '.') }}</span>
                            </td>

                            <!-- AKSI -->
                            <td class="px-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('peminjaman.edit', ['id_peminjaman' => $peminjaman->id_peminjaman]) }}" 
                                       class="btn btn-sm px-2.5 py-1 rounded-2 fw-medium small d-inline-flex align-items-center gap-1.5" 
                                       title="Edit"
                                       style="color: #a855f7; background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2);">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('peminjaman.delete', ['id_peminjaman' => $peminjaman->id_peminjaman]) }}" 
                                          method="POST" 
                                          class="d-inline m-0" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
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
                            <td colspan="9" class="text-center py-5 text-secondary">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-inbox fs-1" style="color: #a855f7; opacity: 0.5;"></i>
                                    <span class="small fw-medium">Belum ada data peminjaman alat yang ditambahkan.</span>
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
