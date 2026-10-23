@extends('layouts.app')

@section('title', config('app.name') . ' — Riwayat Pengajuan Peminjaman')

@section('content')
<div class="container-fluid px-0 py-2">

    <!-- 1. BANNER UTAMA (Hero Gradient Ungu Modern + Tombol Ajukan) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-white hero-banner-purple">
        <div class="hero-bg-shapes"></div>
        <div class="card-body p-4 p-md-5 position-relative z-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur mb-3">
                        <span class="status-indicator"></span>
                        <span class="text-white fw-semibold fs-8 tracking-wider text-uppercase">
                            <i class="bi bi-clock-history me-1 text-warning"></i> Rekapitulasi Riwayat
                        </span>
                    </div>
                    
                    <h2 class="fw-bold mb-2 text-white">Riwayat Peminjaman Alat</h2>
                    <p class="mb-0 text-white-50 fs-6" style="max-width: 650px;">
                        Pantau rekapitulasi pengajuan peminjaman alat, status persetujuan, serta rincian denda Anda secara langsung.
                    </p>
                </div>
                <div>
                    <a href="{{ route('peminjam.createPeminjam') }}" class="btn btn-light px-4 py-2.5 rounded-pill fw-semibold text-dark shadow-sm backdrop-blur d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg text-purple"></i>
                        <span>Ajukan Peminjaman Baru</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TABEL DATA RIWAYAT PEMINJAMAN -->
    <div class="card border-0 shadow-sm rounded-4 bg-body p-4 modern-table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary border-bottom text-secondary text-uppercase fs-8 tracking-wider">
                    <tr>
                        <th class="py-3 px-3 rounded-start-3 text-center" style="width: 60px;">#</th>
                        <th class="py-3">Nama Alat</th>
                        <th class="py-3" style="width: 120px;">Jumlah</th>
                        <th class="py-3" style="width: 140px;">Tgl Pinjam</th>
                        <th class="py-3" style="width: 140px;">Tgl Kembali</th>
                        <th class="py-3 text-center" style="width: 160px;">Status</th>
                        <th class="py-3 px-3 rounded-end-3 text-end" style="width: 140px;">Denda</th>
                    </tr>
                </thead>
                <tbody class="fs-7">
                    @php $no = 1; @endphp
                    @forelse ($datap as $index => $peminjaman)
                    @php
                        // Ambil nama alat dengan aman
                        $alatObj = $peminjaman->alat ?? \App\Models\Alat::find($peminjaman->id_alat ?? null);
                        $namaAlatFinal = $alatObj->nama_alat ?? $alatObj->nama ?? $alatObj->name ?? ('Alat #' . ($peminjaman->id_alat ?? ''));
                    @endphp
                    <tr>
                        <td class="px-3 text-center text-body-secondary fw-medium">
                            {{ method_exists($datap, 'firstItem') ? $datap->firstItem() + $index : $no++ }}
                        </td>
                        <td class="fw-bold text-body-emphasis">
                            <div class="d-flex align-items-center gap-2">
                                <div class="mini-icon-avatar flex-shrink-0">
                                    <i class="bi bi-tools fs-7 text-purple"></i>
                                </div>
                                <span class="fw-semibold text-body-emphasis">{{ $namaAlatFinal }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="code-badge fs-8 fw-bold">
                                <i class="bi bi-box-seam me-1"></i>{{ $peminjaman->jumlah }} Unit
                            </span>
                        </td>
                        <td>
                            <span class="text-body-secondary fs-8 fw-medium">
                                <i class="bi bi-calendar-event me-1"></i>{{ $peminjaman->tanggal_pinjam ? date('d M Y', strtotime($peminjaman->tanggal_pinjam)) : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="text-body-secondary fs-8 fw-medium">
                                @if($peminjaman->tanggal_kembali)
                                    <i class="bi bi-calendar-check me-1"></i>{{ date('d M Y', strtotime($peminjaman->tanggal_kembali)) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </span>
                        </td>
                        <td class="text-center">
                            @if($peminjaman->status == 'Pending')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1.5 fw-semibold fs-8">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            @elseif($peminjaman->status == 'Disetujui' || $peminjaman->status == 'Dipinjam')
                                <span class="badge rounded-pill px-3 py-1.5 fw-semibold fs-8" style="background: rgba(168, 85, 247, 0.12); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.25);">
                                    <i class="bi bi-tools me-1"></i> {{ $peminjaman->status == 'Disetujui' ? 'Disetujui' : 'Dipinjam' }}
                                </span>
                            @elseif($peminjaman->status == 'Ditolak')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1.5 fw-semibold fs-8">
                                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 fw-semibold fs-8">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                </span>
                            @endif
                        </td>
                        <td class="px-3 text-end">
                            @if(($peminjaman->denda ?? 0) > 0)
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded-2 fs-8 fw-bold">
                                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-body-tertiary fs-8 fw-semibold">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <div class="py-3">
                                <i class="bi bi-inbox display-5 text-muted opacity-50 mb-3 d-block"></i>
                                <span class="fw-medium">Belum ada riwayat pengajuan peminjaman alat.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Bagian Pagination -->
        @if(method_exists($datap, 'hasPages') && $datap->hasPages())
        <div class="d-flex justify-content-end mt-4 pt-3 border-top border-translucent">
            {!! $datap->links() !!}
        </div>
        @endif
    </div>

</div>

<!-- 🎨 STYLING KUSTOM KHUSUS TEMA UNGU & ADAPTIF MODE GELAP/TERANG -->
<style>
    /* Banner Hero Ungu */
    .hero-banner-purple {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    .hero-bg-shapes {
        position: absolute;
        top: -60px;
        right: -60px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.25) 0%, rgba(168, 85, 247, 0.2) 50%, transparent 100%);
        filter: blur(50px);
        pointer-events: none;
    }

    .backdrop-blur {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* Animasi Indikator Lampu Berkedip */
    .status-indicator {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: statusPulse 1.8s infinite ease-in-out;
    }

    @keyframes statusPulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    .text-purple {
        color: #a855f7 !important;
    }

    /* Table & Badge Styling */
    .modern-table-card {
        border: 1px solid var(--bs-border-color-translucent) !important;
    }

    .code-badge {
        color: #a855f7;
        background: rgba(168, 85, 247, 0.1);
        padding: 5px 10px;
        border-radius: 8px;
        border: 1px solid rgba(168, 85, 247, 0.2);
    }

    .mini-icon-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(168, 85, 247, 0.12);
        color: #a855f7;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(168, 85, 247, 0.2);
    }

    .fs-7 { font-size: 0.875rem; }
    .fs-8 { font-size: 0.75rem; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection
