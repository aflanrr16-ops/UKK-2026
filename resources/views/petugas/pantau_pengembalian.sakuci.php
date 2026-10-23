@extends('layouts.app')

@section('title', config('app.name') . ' — Pantau Pengembalian')

@section('content')
<div class="container-fluid px-0 py-2">

    <!-- 1. BANNER UTAMA (Hero Gradient Ungu Modern) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-white hero-banner-purple">
        <div class="hero-bg-shapes"></div>
        <div class="card-body p-4 p-md-5 position-relative z-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur mb-3">
                        <span class="status-indicator"></span>
                        <span class="text-white fw-semibold fs-8 tracking-wider text-uppercase">
                            <i class="bi bi-shield-check me-1 text-warning"></i> Panel Petugas Operasional
                        </span>
                    </div>
                    
                    <h2 class="fw-bold mb-2 text-white">Pantau Pengembalian Alat</h2>
                    <p class="mb-0 text-white-50 fs-6" style="max-width: 650px;">
                        Memantau riwayat pengembalian, pengecekan kondisi barang, serta rekapitulasi data dari siswa secara berkala.
                    </p>
                </div>
                <div>
                    <a href="{{ route('petugas.pengembalian.cetak') }}" target="_blank" class="btn btn-light px-4 py-2.5 rounded-pill fw-semibold text-dark shadow-sm backdrop-blur d-inline-flex align-items-center gap-2">
                        <i class="bi bi-printer text-purple"></i>
                        <span>Cetak Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TABEL DATA PENGEMBALIAN -->
    <div class="card border-0 shadow-sm rounded-4 bg-body p-4 modern-table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary border-bottom text-secondary text-uppercase fs-8 tracking-wider">
                    <tr>
                        <th class="py-3 px-3 rounded-start-3" style="width: 60px;">#</th>
                        <th class="py-3" style="width: 140px;">Tgl Kembali</th>
                        <th class="py-3">Nama Peminjam</th>
                        <th class="py-3">Nama Alat</th>
                        <th class="py-3" style="width: 150px;">Kondisi</th>
                        <th class="py-3 px-3 rounded-end-3 text-end" style="width: 130px;">Status</th>
                    </tr>
                </thead>
                <tbody class="fs-7">
                    @forelse($datap as $index => $item)
                        @php
                            $peminjaman = $peminjamanList[$item->id_peminjaman] ?? null;
                            $namaUser = $peminjaman ? ($userList[$peminjaman->id_user] ?? 'Tidak diketahui') : 'Tidak diketahui';
                            $namaAlat = $peminjaman ? ($alatList[$peminjaman->id_alat] ?? 'Alat dihapus') : 'Alat dihapus';
                        @endphp
                        <tr>
                            <td class="px-3 text-body-secondary fw-medium">{{ $datap->firstItem() + $index }}</td>
                            <td class="fw-semibold">
                                <span class="code-badge fs-8 fw-bold">
                                    <i class="bi bi-calendar-check me-1"></i>{{ date('d M Y', strtotime($item->tanggal_pengembalian)) }}
                                </span>
                            </td>
                            <td class="fw-bold text-body-emphasis">
                                <i class="bi bi-person me-1.5 text-secondary"></i>{{ $namaUser }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="mini-icon-avatar flex-shrink-0">
                                        <i class="bi bi-tools fs-7 text-purple"></i>
                                    </div>
                                    <span class="fw-medium text-body-emphasis">{{ $namaAlat }}</span>
                                </div>
                            </td>
                            <td>
                                @if(strtolower($item->kondisi_barang) == 'baik')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-semibold fs-8">
                                        <i class="bi bi-check-circle-fill me-1"></i> Baik
                                    </span>
                                @elseif(strtolower($item->kondisi_barang) == 'ringan rusak' || strtolower($item->kondisi_barang) == 'rusak ringan')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1.5 rounded-pill fw-semibold fs-8">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i> Rusak Ringan
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill fw-semibold fs-8">
                                        <i class="bi bi-x-circle-fill me-1"></i> {{ $item->kondisi_barang ?? 'Rusak' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 text-end">
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 fw-semibold fs-8">
                                    <i class="bi bi-check2-all me-1"></i> Selesai
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <div class="py-3">
                                    <i class="bi bi-inbox display-5 text-muted opacity-50 mb-3 d-block"></i>
                                    <span class="fw-medium">Belum ada data pengembalian alat yang tercatat.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($datap->hasPages())
            <div class="d-flex justify-content-end mt-4 pt-3 border-top border-translucent">
                {{ $datap->links() }}
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

    .status-indicator {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981;
    }

    .text-purple {
        color: #a855f7 !important;
    }

    /* Modern Card Table & Badge Styling */
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
