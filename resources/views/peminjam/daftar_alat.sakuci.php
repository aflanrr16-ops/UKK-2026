@extends('layouts.app')

@section('title', config('app.name') . ' — Katalog Peralatan Modern')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <!-- 🌟 BANNER HEADER MODERN (Hero Gradient Ungu + Status Berkedip) -->
    <div class="card border-0 rounded-4 mb-4 shadow-sm overflow-hidden position-relative text-white hero-banner-purple">
        <div class="hero-bg-shapes"></div>
        <div class="card-body p-4 p-lg-5 position-relative z-2">
            <div class="row align-items-center g-4">
                
                <!-- Sisi Kiri: Judul & Subtitle -->
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur mb-3">
                        <span class="status-indicator"></span>
                        <span class="text-white fw-semibold fs-8 tracking-wider text-uppercase">Katalog Peminjaman Alat Sekolah Digital</span>
                    </div>
                    <h1 class="display-6 fw-extrabold text-white mb-2 tracking-tight">
                        Temukan & Pinjam <span class="text-gradient">Peralatan</span>
                    </h1>
                    <p class="text-white-50 mb-0 fs-6 col-xl-10">
                        Cari alat praktik atau laboratorium secara instan, cek ketersediaan unit, dan ajukan peminjaman langsung dari dashboard Anda.
                    </p>
                </div>

                <!-- Sisi Kanan: Live Search Bar & Filter -->
                <div class="col-lg-5">
                    <div class="glass-search-box p-3 rounded-4 border border-white border-opacity-20 backdrop-blur shadow-sm">
                        <form action="{{ route('peminjam.alat') }}" method="GET">
                            <label class="form-label text-white-50 fw-semibold fs-8 mb-2 tracking-wider text-uppercase">Pencarian Cepat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 text-muted ps-3 pe-2">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="q" class="form-control bg-white border-0 fs-7 shadow-none text-dark" 
                                       placeholder="Cari nama alat" 
                                       value="{{ request('q') }}">
                                <button class="btn btn-light px-4 fw-bold text-purple shadow-none ms-2 rounded-3" type="submit">
                                    Cari
                                </button>
                            </div>
                            @if(request('q'))
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-10">
                                    <span class="fs-8 text-white-50">Hasil pencarian: "{{ request('q') }}"</span>
                                    <a href="{{ route('peminjam.alat') }}" class="fs-8 text-info text-decoration-none hover-underline">Reset Filter</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @php
        $rawAlats = $alats ?? $alat ?? [];
        $searchQuery = trim(request('q') ?? '');

        $filteredAlats = [];
        foreach ($rawAlats as $item) {
            $namaAlat = $item->nama_alat ?? $item->nama ?? $item->name ?? '';
            $kodeAlat = $item->kode_alat ?? $item->kode ?? '';

            if (!empty($searchQuery)) {
                if (stripos($namaAlat, $searchQuery) !== false || stripos($kodeAlat, $searchQuery) !== false) {
                    $filteredAlats[] = $item;
                }
            } else {
                $filteredAlats[] = $item;
            }
        }
    @endphp

    <!-- Bar Informasi Status Total -->
    <div class="d-flex align-items-center justify-content-between mb-4 px-1">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-square rounded-circle me-1 text-purple" style="background: rgba(168, 85, 247, 0.12);">
                <i class="bi bi-box-seam-fill fs-7"></i>
            </div>
            <span class="text-body-secondary fs-7 fw-medium">
                Menampilkan <strong class="text-body-emphasis fw-bold">{{ count($filteredAlats) }}</strong> peralatan tersedia
            </span>
        </div>
    </div>

    <!-- 📦 GRID KATALOG ALAT MODERN -->
    <div class="row g-4 align-items-stretch">
        @forelse($filteredAlats as $item)
            @php
                $namaKategori = $kategoriMap[$item->id_kategori] ?? 'Umum';
                $alatId       = $item->id_alat ?? $item->id;
                $namaAlat     = $item->nama_alat ?? $item->nama ?? $item->name ?? 'Alat #' . $alatId;
                $kodeAlat     = $item->kode_alat ?? $item->kode ?? 'ALT';
                $stokAlat     = $item->stok ?? $item->jumlah ?? null;
            @endphp
            
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm modern-product-card position-relative bg-body overflow-hidden">
                    
                    <!-- Header Card: Position Center & QR Code Jarak Diregangkan -->
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center gap-3">
                        <span class="badge category-chip px-3 py-2 rounded-pill fs-8 fw-semibold text-wrap text-start lh-sm d-inline-flex align-items-center" style="max-width: 62%;">
                            <i class="bi bi-folder2-open me-2 fs-7 flex-shrink-0"></i> 
                            <span>{{ $namaKategori }}</span>
                        </span>
                        
                        <span class="code-badge fs-8 fw-bold tracking-wider d-inline-flex align-items-center justify-content-center text-center flex-shrink-0" style="max-width: 38%;">
                            <i class="bi bi-qr-code fs-6 text-purple me-2"></i>
                            <span class="text-break">{{ $kodeAlat }}</span>
                        </span>
                    </div>

                    <!-- Body Card: Main Icon & Product Details -->
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        
                        <div class="d-flex align-items-start gap-3 my-2">
                            <!-- Visual Avatar Box -->
                            <div class="modern-icon-avatar flex-shrink-0 mt-1">
                                <i class="bi bi-layers-half fs-4"></i>
                            </div>

                            <div class="flex-grow-1">
                                <!-- Nama alat menyambung ke bawah jika panjang -->
                                <h5 class="fw-bold fs-6 text-body-emphasis mb-2 text-wrap lh-sm">
                                    {{ $namaAlat }}
                                </h5>
                                
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    @if(isset($stokAlat))
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-8 px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-1.5"></i> Stok: {{ $stokAlat }} Unit
                                        </span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-8 px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-1.5"></i> Ready Dipinjam
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Footer Action Button -->
                        <div class="pt-3.5 mt-3 border-top border-translucent">
                            <a href="{{ route('peminjam.createPeminjam') . '?id_alat=' . $alatId }}" 
                               class="btn btn-action-borrow w-100 py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-3 shadow-sm">
                                <i class="bi bi-handbag-fill fs-6"></i>
                                <span>Ajukan Peminjaman</span>
                                <i class="bi bi-arrow-right-short fs-5 ms-1"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 rounded-4 shadow-sm p-5 text-center bg-body">
                    <div class="py-4">
                        <div class="empty-state-icon mb-3 mx-auto">
                            <i class="bi bi-box-seam display-4 text-muted"></i>
                        </div>
                        <h5 class="fw-bold text-body-emphasis mb-1">Peralatan Tidak Ditemukan</h5>
                        <p class="text-secondary fs-8 mb-4">Tidak ada data alat yang cocok dengan kata kunci pencarian Anda.</p>
                        <a href="{{ route('peminjam.alat') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold fs-8">
                            Tampilkan Semua Alat
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</div>

<!-- 🎨 CUSTOM STYLESHEET -->
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

    .text-gradient {
        background: linear-gradient(135deg, #f3e8ff 0%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .backdrop-blur {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .glass-search-box {
        background: rgba(255, 255, 255, 0.05);
    }

    /* Animasi Lampu Indikator Status Berkedip (Pulse) */
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

    /* Product Card Styling */
    .modern-product-card {
        border: 1px solid var(--bs-border-color-translucent) !important;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .modern-product-card:hover {
        transform: translateY(-5px);
        border-color: rgba(139, 92, 246, 0.4) !important;
        box-shadow: 0 12px 28px -6px rgba(0, 0, 0, 0.25) !important;
    }

    .category-chip {
        background: rgba(139, 92, 246, 0.12);
        color: #a855f7;
        border: 1px solid rgba(139, 92, 246, 0.25);
    }

    .code-badge {
        color: #a855f7;
        background: rgba(139, 92, 246, 0.1);
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    .modern-icon-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(99, 102, 241, 0.15) 100%);
        color: #a855f7;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    .btn-action-borrow {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-action-borrow:hover {
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.35) !important;
        transform: translateY(-1px);
    }

    .icon-square {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-purple {
        color: #a855f7 !important;
    }

    .fs-7 { font-size: 0.875rem; }
    .fs-8 { font-size: 0.75rem; }
    .tracking-wider { letter-spacing: 0.05em; }
    .hover-underline:hover { text-decoration: underline !important; }
</style>
@endsection
