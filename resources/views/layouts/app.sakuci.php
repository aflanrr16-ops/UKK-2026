<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    <script>
        (function () {
            var saved = localStorage.getItem('sakuci-theme');
            var theme = saved || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', theme);

            var sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === null || sidebarState === 'collapsed') {
                document.documentElement.classList.add('preload-collapsed');
            }
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- PUSAT CSS SIDEBAR & DESAIN MODERN (COMPACT TANPA JS) -->
    <style>
        .app-sidebar {
            width: 260px;
            min-width: 260px;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1040;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--bs-box-shadow-sm);
            overflow-y: auto;
        }

        /* Custom Scrollbar Tipis & Estetik */
        .app-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .app-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .app-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        .main-wrapper {
            flex-grow: 1;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 0;
        }

        /* Saat sidebar ditutup (collapsed) */
        body.sidebar-collapsed .app-sidebar,
        html.preload-collapsed body .app-sidebar {
            margin-left: -260px;
        }

        /* Desain Link Menu Sidebar yang Lebih Rapat & Pas di Satu Layar */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 8px;
            padding: 0.5rem 0.85rem; /* Padding dirapatkan agar muat semua */
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            color: var(--bs-body-color);
            opacity: 0.8;
            transition: all 0.2s ease;
            position: relative;
            z-index: 2;
        }
        .sidebar-link i {
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .sidebar-link:hover {
            opacity: 1;
            background-color: var(--bs-tertiary-bg);
            color: var(--bs-primary);
        }
        .sidebar-link:hover i {
            transform: scale(1.1);
        }

        /* Status Aktif (Warna Biru Modern) */
        .sidebar-link.active {
            opacity: 1 !important;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
        }
        .sidebar-link.active i {
            color: #ffffff !important;
        }

        .sidebar-heading {
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
            margin-top: 0.6rem;
            margin-bottom: 0.2rem;
        }
    </style>
</head>
<body class="bg-body-tertiary">

    <div class="d-flex min-vh-100">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Konten Utama --}}
        <div class="main-wrapper d-flex flex-column">
            
            <!-- Navbar Atas untuk Tombol Trigger Sidebar -->
            <header class="navbar bg-body border-bottom px-4 py-2.5 sticky-top shadow-xs">
                <button id="sidebarToggle" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2 px-3 py-1.5 rounded-3 border-0 bg-body-secondary" type="button" aria-label="Toggle Sidebar">
                    <i class="bi bi-list fs-5"></i>
                    <span class="d-none d-sm-inline fw-medium">Menu</span>
                </button>
            </header>

            <main class="container-fluid flex-grow-1 p-4 p-lg-5">
                @include('partials.flash')
                @yield('content')
            </main>

            @include('partials.footer')
            
        </div>

    </div>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>

<!-- Skrip Pengontrol Toggle Sidebar (Bawaan Asli) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarToggleClose');
        const body = document.body;

        if (!localStorage.getItem('sidebarState')) {
            localStorage.setItem('sidebarState', 'collapsed');
        }

        if (localStorage.getItem('sidebarState') === 'collapsed') {
            body.classList.add('sidebar-collapsed');
        }

        function toggleSidebar() {
            body.classList.toggle('sidebar-collapsed');
            document.documentElement.classList.remove('preload-collapsed');
            
            if (body.classList.contains('sidebar-collapsed')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        }

        if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
    });
</script>

@yield('scripts')

</body>
</html>