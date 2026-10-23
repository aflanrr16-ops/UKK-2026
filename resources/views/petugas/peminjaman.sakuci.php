@extends('layouts.app')

@section('title', config('app.name') . ' — Verifikasi Peminjaman')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">
    
    <!-- Header Banner Utama (Theme Ungu / Violet Sakuci) -->
    <div class="card border-0 rounded-4 overflow-hidden mb-4 shadow-sm text-white position-relative header-gradient-modern">
        
        <div class="banner-pattern"></div>
        <div class="banner-glow-purple"></div>

        <div class="card-body p-4 p-md-4 position-relative z-1">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill px-3 py-1.5 fw-semibold small text-uppercase tracking-wider"
                              style="background-color: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3);">
                            <i class="bi bi-shield-check me-1"></i> Verifikasi Operasional
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-white">Persetujuan Peminjaman Alat</h3>
                    <p class="text-white-50 small mb-0" style="max-width: 620px;">
                        Verifikasi dan proses pengajuan peminjaman alat serta inventaris sekolah dari siswa.
                    </p>
                </div>
                <div>
                    <a href="{{ route('petugas.dashboard') }}" class="btn btn-light px-3 py-2 rounded-pill fw-semibold text-dark shadow-sm backdrop-blur d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div class="small fw-medium">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div class="small fw-medium">{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Verifikasi Peminjaman -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-body">
        <div class="card-header bg-body border-bottom py-3 px-4">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-hourglass-split text-purple fs-5"></i>
                <div>
                    <h6 class="card-title mb-0 fw-semibold text-body-emphasis">Antrean Verifikasi Peminjaman</h6>
                    <span class="text-secondary small">Setujui atau tolak pengajuan agar proses peminjaman jelas</span>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary border-bottom text-secondary text-uppercase small tracking-wider">
                        <tr>
                            <th class="py-3 px-4 text-center" style="width: 5%;">NO</th>
                            <th class="py-3 px-3">ID PEMINJAMAN</th>
                            <th class="py-3 px-3">ALAT &amp; PEMINJAM</th>
                            <th class="py-3 px-3">STATUS</th>
                            <th class="py-3 px-4 text-center" style="width: 230px;">AKSI PETUGAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datap as $index => $item)
                        @php
                            $no = method_exists($datap, 'firstItem') ? $datap->firstItem() + $index : $index + 1;
                        @endphp
                        <tr>
                            <td class="px-4 text-center text-secondary fw-medium small">{{ $no }}</td>
                            <td class="px-3">
                                <span class="badge bg-body-secondary text-body-emphasis border font-monospace px-2.5 py-1.5 rounded-2 small">
                                    #{{ $item->id_peminjaman }}
                                </span>
                            </td>
                            <td class="px-3">
                                <div class="fw-bold text-body-emphasis small">
                                    <!-- Ikon alat diganti dengan bi-tools -->
                                    <i class="bi bi-tools text-purple me-1"></i>
                                    {{ $item->data_alat->nama_alat ?? ($item->data_alat->nama ?? 'Alat ID: ' . $item->id_alat) }}
                                </div>
                                <div class="small text-secondary mt-0.5 text-uppercase">
                                    <i class="bi bi-person me-1"></i>{{ $item->data_user->username ?? ($item->data_user->name ?? 'User ID: ' . $item->id_user) }}
                                </div>
                            </td>
                            <td class="px-3">
                                @if(strtolower($item->status) == 'pending' || strtolower($item->status) == 'menunggu')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1.5 rounded-2 small fw-semibold">Pending</span>
                                @elseif(strtolower($item->status) == 'disetujui' || strtolower($item->status) == 'dipinjam')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-2 small fw-semibold">Disetujui</span>
                                @elseif(strtolower($item->status) == 'ditolak')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded-2 small fw-semibold">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded-2 small fw-semibold">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                @if(strtolower($item->status) == 'pending' || strtolower($item->status) == 'menunggu')
                                    <div class="d-inline-flex gap-2">
                                        <form action="{{ route('petugas.peminjaman.setujui', [$item->id_peminjaman]) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-purple-fill rounded-2 px-3 py-1.5 fw-semibold shadow-sm small d-inline-flex align-items-center gap-1 text-white">
                                                <i class="bi bi-check2"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('petugas.peminjaman.tolak', [$item->id_peminjaman]) }}" method="POST" class="m-0"
                                              onsubmit="return confirm('Tolak pengajuan peminjaman ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-3 py-1.5 fw-semibold small d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif(strtolower($item->status) == 'ditolak')
                                    <span class="text-danger small fw-semibold d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-x-circle fs-6"></i> Telah Ditolak
                                    </span>
                                @else
                                    <span class="text-success small fw-semibold d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-check-all fs-6"></i> Telah Disetujui
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-inbox fs-1 opacity-50 text-secondary"></i>
                                    <span class="small fw-medium">Belum ada data pengajuan peminjaman yang perlu diverifikasi.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($datap, 'hasPages') && $datap->hasPages())
            <div class="card-footer bg-body border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="small text-secondary">
                    Menampilkan {{ $datap->firstItem() }} sampai {{ $datap->lastItem() }} dari {{ $datap->total() }} data
                </div>
                <div>
                    {!! $datap->links() !!}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .header-gradient-modern {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%) !important;
    }

    .banner-pattern {
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.5;
        pointer-events: none;
    }

    .banner-glow-purple {
        position: absolute;
        top: -60px; right: -60px;
        width: 250px; height: 250px;
        background: rgba(168, 85, 247, 0.35);
        filter: blur(60px);
        border-radius: 50%;
        pointer-events: none;
    }

    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .text-purple {
        color: #a855f7 !important;
    }

    .btn-purple-fill {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        border: none;
        transition: all 0.2s ease;
    }

    .btn-purple-fill:hover {
        opacity: 0.95;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.35) !important;
    }

    .tracking-wider { letter-spacing: 0.06em; }
</style>
@endsection
