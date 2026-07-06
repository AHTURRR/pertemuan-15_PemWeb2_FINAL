<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Perpustakaan'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="app-shell">
        @include('layouts.navigation')

        <div class="app-main">
            @auth
                <header class="topbar">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-icon d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Buka menu">
                            <i class="bi bi-list"></i>
                        </button>
                        <div>
                            <p class="eyebrow mb-1">{{ now()->translatedFormat('l, d F Y') }}</p>
                            <h1 class="topbar-title">@yield('title', 'Sistem Perpustakaan')</h1>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-grow-1 justify-content-end ms-4" style="max-width: 600px;">
                        <form class="d-flex flex-grow-1" action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 999px 0 0 999px; border-color: var(--border);"><i class="bi bi-search text-muted"></i></span>
                                <input class="form-control border-start-0 ps-0" style="border-radius: 0 999px 999px 0; border-color: var(--border); box-shadow: none;" type="search" name="q"
                                       placeholder="Cari buku, anggota, transaksi..." value="{{ request('q') }}">
                            </div>
                        </form>

                        <div class="dropdown">
                            <button class="btn user-menu dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="avatar">{{ Str::of(Auth::user()->name)->substr(0, 1)->upper() }}</span>
                                <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2"></i> Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" data-loading="true">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>
            @endauth

            <main class="content-wrap">
                @if (session('success') || session('error') || session('warning') || session('info'))
                    <div class="toast-message d-none"
                        data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : 'info')) }}"
                        data-message="{{ session('success') ?? session('error') ?? session('warning') ?? session('info') }}">
                    </div>
                @endif

                @isset($header)
                    <div class="mb-4">
                        {{ $header }}
                    </div>
                @endisset

                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>

            @includeIf('layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
