@php
    $currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

    $currentUser = $user ?? \App\Models\User::current();
    $role = $currentUser->role ?? 'siswa';

    $logoUrl = route('dashboard');
    if ($currentUser) {
        if ($role === 'admin') {
            $logoUrl = route('admin.dashboard');
        } elseif ($role === 'petugas') {
            $logoUrl = route('petugas.dashboard');
        } elseif ($role === 'peminjam') {
            $logoUrl = route('peminjam.dashboard');
        }
    } else {
        $logoUrl = route('home');
    }

    $isActive = function(...$paths) use ($currentUri) {
        foreach ($paths as $path) {
            if (empty($path)) continue;
            if ($path === '/' && ($currentUri === '/' || str_ends_with($currentUri, '/public/'))) return true;
            if ($path !== '/' && str_contains($currentUri, $path)) return true;
        }
        return false;
    };
@endphp

<!-- CSS Kustom Adaptif Mode Terang & Gelap (Purple & Violet Theme) -->
<style>
    /* Variabel Warna Tema Ungu */
    :root {
        --purple-primary: #a855f7;
        --purple-dark: #7c3aed;
        --purple-gradient: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        --purple-hover-bg: rgba(168, 85, 247, 0.12);
        --purple-active-shadow: 0 4px 12px rgba(124, 58, 237, 0.35);
    }

    /* Toggle Ikon Mode Gelap/Terang (Laptop & Lampu, warna hitam pada mode terang agar terlihat jelas) */
    #themeToggle .icon-light-mode { display: none; }
    #themeToggle .icon-dark-mode { display: inline-block; }

    [data-bs-theme="light"] #themeToggle .icon-light-mode { display: inline-block; color: #000000 !important; }
    [data-bs-theme="light"] #themeToggle .icon-dark-mode { display: none; }

    /* Custom Sidebar Body - Tanpa delay/transisi agar muncul instan saat tombol diklik */
    .custom-sidebar {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        transition: none !important; 
    }

    /* Brand Logo Icon Circle & Sleek */
    .brand-icon-wrapper {
        background: var(--purple-gradient);
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.4);
        transition: transform 0.2s ease;
    }
    
    .brand-logo-link:hover .brand-icon-wrapper {
        transform: scale(1.08) rotate(-5deg);
    }

    .brand-logo-title {
        color: var(--purple-primary) !important;
    }

    /* Style Sidebar Link yang Adaptif untuk Mode Gelap & Terang */
    .sidebar-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0.85rem;
        color: var(--bs-body-color, #212529) !important;
        text-decoration: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .sidebar-link i {
        font-size: 1.1rem;
        color: var(--purple-primary);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
    }

    /* Hover State */
    .sidebar-link:hover {
        background-color: var(--purple-hover-bg);
        color: var(--purple-primary) !important;
        padding-left: 1.1rem;
    }

    .sidebar-link:hover i {
        color: var(--purple-primary) !important;
    }

    /* Active State (Ungu Gradien dengan Kontras Tinggi) */
    .sidebar-link.active {
        background: var(--purple-gradient) !important;
        color: #ffffff !important;
        font-weight: 600;
        box-shadow: var(--purple-active-shadow);
    }

    .sidebar-link.active i {
        color: #ffffff !important;
    }

    /* Section Heading Adaptif */
    .sidebar-heading {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--bs-secondary-color, #6c757d) !important;
        margin-top: 1.25rem;
        margin-bottom: 0.4rem;
        padding-left: 0.85rem;
    }

    /* Floating User Card Compact */
    .user-profile-card {
        background: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color-translucent);
        border-radius: 0.75rem;
    }

    .user-avatar-purple {
        background: var(--purple-gradient) !important;
    }

    .badge-purple {
        background: rgba(168, 85, 247, 0.15) !important;
        color: var(--purple-primary) !important;
        border: 1px solid rgba(168, 85, 247, 0.3) !important;
    }

    /* Custom Purple Buttons untuk Guest */
    .btn-purple-outline {
        color: var(--purple-primary);
        border-color: var(--purple-primary);
    }
    .btn-purple-outline:hover {
        background-color: var(--purple-primary);
        color: #ffffff;
    }

    .btn-purple-fill {
        background: var(--purple-gradient);
        color: #ffffff;
        border: none;
    }
    .btn-purple-fill:hover {
        opacity: 0.9;
        color: #ffffff;
    }

    .btn-logout-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        border: none;
        background: transparent;
        color: var(--bs-danger);
    }

    .btn-logout-icon:hover {
        background-color: rgba(220, 53, 69, 0.15);
    }
</style>

<!-- Sidebar Utama -->
<div id="appSidebar" class="app-sidebar custom-sidebar d-flex flex-column p-3 bg-body border-end vh-100 position-sticky top-0 shadow-sm">
    
    <!-- Header Sidebar -->
    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom flex-shrink-0 px-1">
        <a href="{{ $logoUrl }}" class="brand-logo-link d-flex align-items-center gap-2 text-decoration-none text-body overflow-hidden">
            <!-- Ikon Logo Header: Tas Ransel Sekolah (bi-backpack2-fill) -->
            <div class="brand-icon-wrapper text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                <i class="bi bi-backpack2-fill fs-6"></i>
            </div>
            <div class="d-flex flex-column lh-1">
                <span class="fs-6 fw-bold tracking-wider text-uppercase text-truncate m-0">
                    <span class="brand-logo-title">Alat</span><span class="text-body">Sekolah</span>
                </span>
            </div>
        </a>

        <div class="d-flex align-items-center gap-1">
            <!-- Toggle Mode (Ikon Laptop & Lampu) -->
            <button id="themeToggle" type="button" class="btn btn-sm btn-icon btn-light rounded-circle text-body p-1.5 shadow-sm"
                    aria-label="Ganti tema" title="Ganti tema">
                <i class="bi bi-laptop fs-6 icon-dark-mode"></i>
                <i class="bi bi-lightbulb-fill fs-6 text-warning icon-light-mode"></i>
            </button>

            <!-- Close Mobile -->
            <button id="sidebarToggleClose" class="btn btn-sm btn-link text-body p-0 d-lg-none" aria-label="Tutup Menu">
                <i class="bi bi-x-lg fs-5"></i>
            </button>
        </div>
    </div>

    <!-- Bagian Navigasi Menu dengan Ikon Modern -->
    <div class="flex-grow-1 overflow-y-auto pe-1" style="scrollbar-width: thin;">
        <ul class="nav nav-pills flex-column gap-1 mb-3">
            
            <li>
                @php 
                    $active = (function_exists('is_route') && is_route('home')) || $currentUri === '/' || str_ends_with($currentUri, '/public/'); 
                @endphp
                <a href="{{ route('home') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Beranda Utama</span>
                </a>
            </li>

            {{-- ==================== MENU ADMIN ==================== --}}
            @if($role === 'admin')
                <div class="sidebar-heading">Ringkasan</div>
                <li>
                    @php $active = $isActive('/admin/dashboard') || $currentUri === '/admin' || $currentUri === '/admin/'; @endphp
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <div class="sidebar-heading">Akses & Pengguna</div>
                <li>
                    @php $active = $isActive('/admin/users'); @endphp
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/admin/roles'); @endphp
                    <a href="{{ route('admin.roles.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-shield-lock"></i>
                        <span>Hak Akses (Role)</span>
                    </a>
                </li>

                <div class="sidebar-heading">Alat</div>
                <li>
                    @php $active = $isActive('/admin/kategori'); @endphp
                    <a href="{{ route('kategori.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Kategori Alat</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/admin/alat'); @endphp
                    <a href="{{ route('alat.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-cpu"></i>
                        <span>Data Alat</span>
                    </a>
                </li>

                <div class="sidebar-heading">Transaksi</div>
                <li>
                    @php $active = $isActive('/admin/peminjaman'); @endphp
                    <a href="{{ route('peminjaman.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-journal-check"></i>
                        <span>Peminjaman</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/admin/pengembalian'); @endphp
                    <a href="{{ route('pengembalian.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        <span>Pengembalian</span>
                    </a>
                </li>

                <div class="sidebar-heading">Sistem</div>
                <li>
                    @php $active = $isActive('/admin/log-aktifitas'); @endphp
                    <a href="{{ route('admin.log.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-activity"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/admin/database/export'); @endphp
                    <a href="{{ route('admin.database.export') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-database-exclamation"></i>
                        <span>Backup Database</span>
                    </a>
                </li>

            {{-- ==================== MENU PEMINJAM ==================== --}}
            @elseif($role === 'peminjam')
                <div class="sidebar-heading">Menu Peminjam</div>
                <li>
                    @php $active = $currentUri === '/peminjam' || $currentUri === '/peminjam/' || $isActive('/peminjam/dashboard'); @endphp
                    <a href="{{ route('peminjam.dashboard') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/peminjam/daftar-alat', '/peminjam/alat'); @endphp
                    <a href="{{ route('peminjam.alat') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-collection"></i>
                        <span>Katalog Alat</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/peminjam/ajukan', '/peminjam/create', '/peminjam/peminjam/ajukan'); @endphp
                    <a href="{{ route('peminjam.createPeminjam') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i>
                        <span>Ajukan Peminjaman</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/peminjam/pengembalian'); @endphp
                    <a href="{{ route('peminjam.pengembalian.create') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-in-left"></i>
                        <span>Pengembalian Alat</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/riwayat-peminjaman'); @endphp
                    <a href="{{ route('peminjam.riwayat') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                        <span>Riwayat Aktivitas</span>
                    </a>
                </li>

            {{-- ==================== MENU PETUGAS ==================== --}}
            @elseif($role === 'petugas')
                <div class="sidebar-heading">Akses Petugas</div>
                <li>
                    @php 
                        $active = $currentUri === '/petugas' || 
                                  $currentUri === '/petugas/' || 
                                  $isActive('/petugas/dashboard'); 
                    @endphp
                    <a href="{{ route('petugas.dashboard') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/petugas/peminjaman'); @endphp
                    <a href="{{ route('petugas.peminjaman.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-check2-square"></i>
                        <span>Persetujuan Alat</span>
                    </a>
                </li>
                <li>
                    @php $active = $isActive('/petugas/pengembalian'); @endphp
                    <a href="{{ route('petugas.pengembalian.index') }}" class="sidebar-link {{ $active ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Pantau Pengembalian</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>

    <!-- BAGIAN BAWAH SIDEBAR (Profil Compact / Auth) -->
    <div class="pt-2 flex-shrink-0">
        @if ($currentUser)
            <!-- Profil User Compact -->
            <div class="user-profile-card p-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 overflow-hidden">
                    <div class="user-avatar-purple text-white rounded-circle p-1.5 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.8rem;">
                        {{ strtoupper(substr($currentUser->username ?? 'U', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden lh-sm">
                        <h6 class="mb-0 text-truncate fw-semibold" style="font-size: 0.8rem; color: var(--bs-emphasis-color);">{{ $currentUser->username ?? 'User' }}</h6>
                        <span class="badge badge-purple rounded-pill text-capitalize" style="font-size: 0.6rem; padding: 2px 6px;">
                            {{ $role }}
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn-logout-icon" title="Logout / Keluar" aria-label="Logout">
                        <i class="bi bi-power fs-6"></i>
                    </button>
                </form>
            </div>
        @else
            <!-- Tombol Guest -->
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('login') }}" class="btn btn-sm btn-purple-outline w-100 rounded-3 d-flex align-items-center justify-content-center gap-2 py-2">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span class="fw-medium">Masuk</span>
                </a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-purple-fill w-100 rounded-3 d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm">
                    <i class="bi bi-person-plus-fill"></i>
                    <span class="fw-medium">Daftar Akun</span>
                </a>
            </div>
        @endif
    </div>

</div>
