<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="{{ route('home') }}">
            <svg width="28" height="28" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                <defs>
                    <clipPath id="sakuciLogoClip">
                        <circle cx="16" cy="16" r="16"/>
                    </clipPath>
                </defs>
                <g clip-path="url(#sakuciLogoClip)">
                    <path d="M30 2H2V14H6.76394L9.76392 8L14.23606 8L20 19.52786L22.764 14H30V2Z" fill="#FF0000"/>
                    <path d="M30 18H25.236L22.236 24L17.76394 24L12 12.47214L9.23606 18H2V30H30V18Z" fill="#0066FF"/>
                </g>
                <circle cx="16" cy="16" r="15.5" fill="none" stroke="#333" stroke-width="1"/>
            </svg>
            {{ config('app.name') }}
            @php
                $dbConnected = false;
                try {
                    \Sakuci\Database\Connection::pdo();
                    $dbConnected = true;
                } catch (\Throwable $e) {
                    $dbConnected = false;
                }
            @endphp
            <span class="d-inline-block rounded-circle"
                  style="width: 10px; height: 10px; background-color: {{ $dbConnected ? '#28a745' : '#dc3545' }};"
                  title="{{ $dbConnected ? 'Database terhubung' : 'Database tidak terhubung' }}"></span>
        </a>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#menuUtama"
                aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Tambahkan menu aplikasi Anda di sini --}}
        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('docs') }}">Docs</a>
                </li>
                @php
                    $currentUser = \App\Models\User::current();
                @endphp
                @if ($currentUser)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $currentUser->role === 'admin' ? route('admin.dashboard') : ($currentUser->role === 'staff' ? route('staff.dashboard') : route('dashboard')) }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-lg-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100 mt-2 mt-lg-0">Logout ({{ $currentUser->username }})</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-sm btn-outline-brand mt-2 mt-lg-0" href="{{ route('login') }}">Masuk</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
