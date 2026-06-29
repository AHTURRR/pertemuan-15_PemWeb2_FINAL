@php
    $menuGroups = [
        [
            'label' => 'Dashboard',
            'items' => [
                ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'dashboard', 'active' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Master Data',
            'items' => [
                ['label' => 'Buku', 'icon' => 'bi-journal-bookmark', 'route' => 'buku.index', 'active' => 'buku.*'],
                ['label' => 'Anggota', 'icon' => 'bi-people', 'route' => 'anggota.index', 'active' => 'anggota.*'],
                ['label' => 'Kategori', 'icon' => 'bi-tags', 'route' => 'kategori.index', 'active' => 'kategori.*'],
            ],
        ],
        [
            'label' => 'Transaksi',
            'items' => [
                ['label' => 'Peminjaman', 'icon' => 'bi-bookmark-plus', 'route' => 'transaksi.create', 'active' => 'transaksi.create'],
                ['label' => 'Pengembalian', 'icon' => 'bi-arrow-return-left', 'route' => 'transaksi.index', 'active' => 'transaksi.index'],
                ['label' => 'Laporan Transaksi', 'icon' => 'bi-file-earmark-bar-graph', 'route' => 'transaksi.laporan', 'active' => 'transaksi.laporan*'],
            ],
        ],
        [
            'label' => 'Pengaturan',
            'items' => [
                ['label' => 'Profile', 'icon' => 'bi-person-gear', 'route' => 'profile.edit', 'active' => 'profile.*'],
            ],
        ],
    ];
@endphp

@auth
    <aside class="sidebar d-none d-lg-flex">
        <a class="brand" href="{{ route('dashboard') }}">
            <span class="brand-mark"><i class="bi bi-book-half"></i></span>
            <span>
                <strong>Pustaka</strong>
                <small>Library System</small>
            </span>
        </a>

        <nav class="sidebar-nav" aria-label="Menu utama">
            @foreach ($menuGroups as $group)
                <div class="nav-group">
                    <p class="nav-group-title">{{ $group['label'] }}</p>
                    @foreach ($group['items'] as $item)
                        <a href="{{ route($item['route']) }}"
                           class="sidebar-link {{ request()->routeIs($item['active']) ? 'active' : '' }}"
                           title="{{ $item['label'] }}">
                            <i class="bi {{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>
    </aside>

    <div class="offcanvas offcanvas-start mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <a class="brand" href="{{ route('dashboard') }}" id="mobileSidebarLabel">
                <span class="brand-mark"><i class="bi bi-book-half"></i></span>
                <span>
                    <strong>Pustaka</strong>
                    <small>Library System</small>
                </span>
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="sidebar-nav" aria-label="Menu utama mobile">
                @foreach ($menuGroups as $group)
                    <div class="nav-group">
                        <p class="nav-group-title">{{ $group['label'] }}</p>
                        @foreach ($group['items'] as $item)
                            <a href="{{ route($item['route']) }}"
                               class="sidebar-link {{ request()->routeIs($item['active']) ? 'active' : '' }}">
                                <i class="bi {{ $item['icon'] }}"></i>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>
        </div>
    </div>
@else
    <nav class="navbar navbar-expand-lg guest-navbar">
        <div class="container">
            <a class="brand text-decoration-none" href="{{ route('home') }}">
                <span class="brand-mark"><i class="bi bi-book-half"></i></span>
                <span>
                    <strong>Pustaka</strong>
                    <small>Library System</small>
                </span>
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            </div>
        </div>
    </nav>
@endauth
