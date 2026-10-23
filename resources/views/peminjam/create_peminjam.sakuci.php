@extends('layouts.app')

@section('title', config('app.name') . ' — Ajukan Peminjaman Alat')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    {{-- Tentukan rute action berdasarkan role yang sedang login --}}
    @php
        $currentUser = \App\Models\User::current();
        $isPengguna = $currentUser && ($currentUser->role == 'pengguna');
        $storeRoute = $isPengguna ? route('peminjam.storePeminjam.pengguna') : route('peminjam.storePeminjam');
        $indexRoute = $isPengguna ? route('peminjam.indexPeminjam.pengguna') : route('peminjam.indexPeminjam');
        
        // Menangkap ID alat dari URL
        $selectedAlatId = $_GET['id_alat'] ?? request('id_alat') ?? '';
        
        // Pengaman data alat
        $daftarAlat = $alat ?? $alats ?? \App\Models\Alat::all();

        // Cari nama alat yang sesuai dengan ID dari URL
        $namaAlatTerpilih = '';
        if (!empty($selectedAlatId)) {
            foreach($daftarAlat as $item) {
                $aId = $item->id_alat ?? $item->id;
                if ($aId == $selectedAlatId) {
                    $namaAlatTerpilih = $item->nama_alat ?? $item->nama ?? 'Alat #' . $aId;
                    break;
                }
            }
        }
    @endphp

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            
            <!-- 1. BANNER HEADER RINGKAS (Lebar Presisi Disesuaikan dengan Form) -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-white hero-banner-purple">
                <div class="hero-bg-shapes"></div>
                <div class="card-body p-4 p-md-4.5 position-relative z-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur mb-2">
                                <span class="status-indicator"></span>
                                <span class="text-white fw-semibold fs-8 tracking-wider text-uppercase">
                                    <i class="bi bi-journal-plus me-1 text-warning"></i> Form Peminjaman Alat
                                </span>
                            </div>
                            
                            <h3 class="fw-bold mb-1 text-white">Ajukan Peminjaman Baru</h3>
                            <p class="mb-0 text-white-50 fs-7" style="max-width: 600px;">
                                Lengkapi rincian formulir di bawah ini untuk mengajukan peminjaman alat sekolah.
                            </p>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="rounded-circle p-3 bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="bi bi-tools fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. CARD FORMULIR PENGAJUAN -->
            <div class="card border-0 shadow-sm rounded-4 bg-body p-3 p-md-4 modern-form-card">
                <div class="card-body p-2 p-md-3">

                    <form action="{{ $storeRoute }}" method="POST">
                        @csrf
                        
                        <div class="row g-4 mb-4">
                            <!-- Pilihan Alat -->
                            <div class="col-12 col-md-8">
                                <label for="id_alat" class="form-label fw-semibold fs-7 text-body-emphasis">Pilih Alat <span class="text-danger">*</span></label>
                                
                                @if(!empty($selectedAlatId))
                                    <div class="form-control form-control-lg fs-7 fw-semibold d-flex align-items-center rounded-3 bg-body-tertiary border" style="cursor: not-allowed; min-height: 48px;">
                                         <i class="bi bi-tools text-purple me-2 fs-6"></i>
                                         <span>{{ $namaAlatTerpilih ?: 'Alat #' . $selectedAlatId }}</span>
                                    </div>
                                    <input type="hidden" name="id_alat" value="{{ $selectedAlatId }}">
                                @else
                                    <select name="id_alat" id="id_alat" class="form-select form-select-lg fs-7 rounded-3" required style="min-height: 48px;">
                                        <option value="">-- Pilih Alat --</option>
                                        @foreach($daftarAlat as $item)
                                            @php 
                                                $aId = $item->id_alat ?? $item->id;
                                                $aName = $item->nama_alat ?? $item->nama ?? 'Alat #' . $aId;
                                            @endphp
                                            <option value="{{ $aId }}">
                                                {{ $aName }} @if(isset($item->stok)) (Stok: {{ $item->stok }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <!-- Jumlah -->
                            <div class="col-12 col-md-4">
                                <label for="jumlah" class="form-label fw-semibold fs-7 text-body-emphasis">Jumlah Unit <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control form-control-lg fs-7 rounded-3" min="1" value="1" required placeholder="Jml unit" style="min-height: 48px;">
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div class="col-12 col-md-6">
                                <label for="tanggal_pinjam" class="form-label fw-semibold fs-7 text-body-emphasis">Tanggal Pinjam <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3 text-secondary">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>
                                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control form-control-lg fs-7 rounded-end-3 border-start-0" value="{{ date('Y-m-d') }}" required style="min-height: 48px;">
                                </div>
                            </div>

                            <!-- Tanggal Kembali -->
                            <div class="col-12 col-md-6">
                                <label for="tanggal_kembali" class="form-label fw-semibold fs-7 text-body-emphasis">Rencana Tanggal Kembali <span class="text-secondary fw-normal fs-8">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3 text-secondary">
                                        <i class="bi bi-calendar-check"></i>
                                    </span>
                                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control form-control-lg fs-7 rounded-end-3 border-start-0" style="min-height: 48px;">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 border-translucent">

                        <!-- Tombol Aksi -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <a href="{{ $indexRoute }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-pill fw-semibold fs-7 d-inline-flex align-items-center gap-2">
                                <i class="bi bi-arrow-left"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit" class="btn btn-purple-gradient px-4 py-2.5 rounded-pill fw-semibold fs-7 shadow-sm d-inline-flex align-items-center gap-2">
                                <i class="bi bi-send-fill"></i>
                                <span>Kirim Pengajuan</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- 🎨 STYLING KUSTOM TEMA UNGU MODERN & ADAPTIF -->
<style>
    /* Banner Hero Ungu */
    .hero-banner-purple {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    .hero-bg-shapes {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.25) 0%, rgba(168, 85, 247, 0.2) 50%, transparent 100%);
        filter: blur(40px);
        pointer-events: none;
    }

    .backdrop-blur {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* Animasi Lampu Indikator Berkedip */
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

    .btn-purple-gradient {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-purple-gradient:hover {
        color: #ffffff;
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.35) !important;
    }

    /* Form Card Border */
    .modern-form-card {
        border: 1px solid var(--bs-border-color-translucent) !important;
    }

    .fs-7 { font-size: 0.875rem; }
    .fs-8 { font-size: 0.75rem; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection
