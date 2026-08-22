<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="{{ route('home') }}">
            <svg width="28" height="28" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                <path d="M15 1H1V7H3.38197L4.88196 4L7.11803 4L10 9.76393L11.382 7H15V1Z" fill="#FF0000"/>
                <path d="M15 9H12.618L11.118 12L8.88197 12L6 6.23607L4.61803 9H1V15H15V9Z" fill="#0066FF"/>
            </svg>
            {{ config('app.name') }}
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
