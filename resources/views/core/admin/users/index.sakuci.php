@extends('layouts.app')

@section('title', config('app.name') . ' — Kelola Data User')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <!-- 1. BANNER UTAMA (Hero Gradient Ungu Modern) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-white hero-banner-purple">
        <div class="hero-bg-shapes"></div>
        <div class="card-body p-4 p-md-5 position-relative z-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur mb-3">
                        <span class="status-indicator"></span>
                        <span class="text-white fw-semibold fs-8 tracking-wider text-uppercase">
                            <i class="bi bi-people-fill me-1 text-warning"></i> Manajemen Hak Akses User
                        </span>
                    </div>
                    
                    <h2 class="fw-bold mb-2 text-white">Kelola Pengguna Sistem</h2>
                    <p class="mb-0 text-white-50 fs-6" style="max-width: 650px;">
                        Kelola akun pengguna, ubah hak akses role, perbarui informasi profil, serta tambahkan pengguna baru ke dalam aplikasi.
                    </p>
                </div>
                <div class="d-none d-lg-block">
                    <div class="rounded-circle p-3 bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur text-white d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="bi bi-person-gear fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. LAYOUT DUA KOLOM (Form & Tabel User) -->
    <div class="row g-4">
        
        <!-- KOLOM KIRI: Form Tambah / Edit User -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 bg-body p-3 p-md-4 modern-card h-100">
                <div class="card-header bg-transparent border-0 p-0 mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="mini-icon-avatar">
                            <i class="bi {{ isset($userToEdit) ? 'bi-pencil-square' : 'bi-person-plus-fill' }} fs-6 text-purple"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-body-emphasis">
                            {{ isset($userToEdit) ? 'Edit Data User' : 'Tambah User Baru' }}
                        </h6>
                    </div>
                    @if(isset($userToEdit))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Batal Edit">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>

                <div class="card-body p-0">
                    <form action="{{ isset($userToEdit) ? route('admin.users.update', ['id' => $userToEdit->id]) : route('admin.users.store') }}" method="POST">
                        @csrf
                        @if(isset($userToEdit))
                            @method('PUT')
                        @endif

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold fs-7 text-body-emphasis">Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3 text-secondary">
                                    <i class="bi bi-at"></i>
                                </span>
                                <input type="text" name="username" id="username" class="form-control fs-7 rounded-end-3 border-start-0 @error('username') is-invalid @enderror" 
                                       value="{{ old('username', $userToEdit->username ?? '') }}" required placeholder="Masukkan username" style="min-height: 44px;">
                            </div>
                            @error('username')
                                <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold fs-7 text-body-emphasis">Role Akses <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3 text-secondary">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <select name="role" id="role" class="form-select fs-7 rounded-end-3 border-start-0 @error('role') is-invalid @enderror" required style="min-height: 44px;">
                                    <option value="">-- Pilih Role Akses --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ (old('role', $userToEdit->role ?? '') == $role->name) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role')
                                <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold fs-7 text-body-emphasis">
                                Password {{ isset($userToEdit) ? '' : '*' }}
                                @if(isset($userToEdit))
                                    <span class="text-secondary fw-normal fs-8">(Kosongkan jika tidak diubah)</span>
                                @endif
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3 text-secondary">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control fs-7 rounded-end-3 border-start-0 @error('password') is-invalid @enderror" 
                                       {{ isset($userToEdit) ? '' : 'required' }} placeholder="Min. 6 Karakter" style="min-height: 44px;">
                            </div>
                            @error('password')
                                <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-purple-gradient py-2.5 rounded-3 fw-semibold fs-7 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="bi {{ isset($userToEdit) ? 'bi-check-circle-fill' : 'bi-plus-lg' }}"></i>
                                <span>{{ isset($userToEdit) ? 'Simpan Perubahan' : 'Tambahkan User' }}</span>
                            </button>
                            @if(isset($userToEdit))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary py-2.5 rounded-3 fw-semibold fs-7">
                                    Batal Edit
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Tabel Daftar User -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-body p-3 p-md-4 modern-card h-100">
                <div class="card-header bg-transparent border-0 p-0 mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-list-stars text-purple fs-5"></i>
                        <h6 class="fw-bold mb-0 text-body-emphasis">Daftar Pengguna Terdaftar</h6>
                    </div>
                    <span class="badge category-chip px-3 py-1.5 rounded-pill fs-8 fw-bold">
                        Total: {{ count($users) }} User
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-body-tertiary border-bottom text-secondary text-uppercase fs-8 tracking-wider">
                                <tr>
                                    <th class="py-3 px-4 text-center" style="width: 70px;">#</th>
                                    <th class="py-3 px-3">Username</th>
                                    <th class="py-3 px-3 text-center" style="width: 160px;">Role</th>
                                    <th class="py-3 px-4 text-end" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fs-7">
                                @forelse($users as $index => $u)
                                    <tr>
                                        <td class="py-3.5 px-4 text-center text-body-secondary fw-medium fs-8">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="py-3.5 px-3 fw-bold text-body-emphasis">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="mini-icon-avatar flex-shrink-0">
                                                    <i class="bi bi-person-circle fs-6 text-purple"></i>
                                                </div>
                                                <span class="fw-semibold text-body-emphasis">{{ $u->username }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-3 text-center">
                                            @if(strtolower($u->role) === 'admin' || strtolower($u->role) === 'petugas')
                                                <span class="badge rounded-pill px-3 py-1.5 fs-8 fw-semibold" style="background: rgba(168, 85, 247, 0.12); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.25);">
                                                    <i class="bi bi-shield-check me-1"></i> {{ ucfirst($u->role) }}
                                                </span>
                                            @else
                                                <span class="badge bg-body-tertiary text-body-secondary border rounded-pill px-3 py-1.5 fs-8 fw-semibold">
                                                    <i class="bi bi-person me-1"></i> {{ ucfirst($u->role) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-end">
                                            <div class="d-inline-flex gap-2">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('admin.users.edit', ['id' => $u->id]) }}" class="btn btn-sm btn-outline-purple rounded-2 px-2.5 py-1.5" title="Edit User">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                <!-- Form Hapus -->
                                                <form action="{{ route('admin.users.destroy', ['id' => $u->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-2.5 py-1.5" title="Hapus User">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-secondary">
                                            <div class="py-3">
                                                <i class="bi bi-people display-6 text-muted opacity-50 mb-2 d-block"></i>
                                                <span class="fw-medium">Belum ada data user terdaftar.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- 🎨 STYLING KUSTOM KHUSUS TEMA UNGU & ADAPTIF MODE GELAP/TERANG -->
<style>
    /* Hero Banner Ungu */
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

    /* Lampu Indikator Berkedip */
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

    .btn-outline-purple {
        color: #a855f7;
        border-color: rgba(168, 85, 247, 0.4);
        background: transparent;
    }

    .btn-outline-purple:hover {
        background: #a855f7;
        color: #ffffff;
    }

    /* Modern Card & Element Styling */
    .modern-card {
        border: 1px solid var(--bs-border-color-translucent) !important;
    }

    .category-chip {
        background: rgba(168, 85, 247, 0.12);
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.25);
    }

    .mini-icon-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(168, 85, 247, 0.12);
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
