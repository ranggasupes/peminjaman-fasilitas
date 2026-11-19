
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Peminjaman Fasilitas') - FasilitasKu</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<>

    @auth
        <div class="app-shell">

            <aside class="sidebar" id="sidebar">

                <a href="{{ url('/') }}" class="brand">
                    <span class="brand-icon">F</span>

                    <span>
                        <strong>FasilitasKu</strong>
                        <small>Layanan Peminjaman</small>
                    </span>
                </a>

                <div class="sidebar-label">MENU UTAMA</div>

                <nav class="nav-menu">

                    {{-- SUPER ADMIN --}}
                    @if (auth()->user()->role?->nama_role === 'super_admin')

                        <a href="{{ route('dashboard.super-admin') }}"
                           class="nav-link {{ request()->routeIs('dashboard.super-admin') ? 'active' : '' }}">
                            <span class="nav-icon">⌂</span>
                            Dashboard
                        </a>

                        <a href="{{ route('instansi.index') }}"
                           class="nav-link {{ request()->routeIs('instansi.*') ? 'active' : '' }}">
                            <span class="nav-icon">▤</span>
                            Data Instansi
                        </a>

                        <a href="{{ route('fasilitas.index') }}"
                           class="nav-link {{ request()->routeIs('fasilitas.*') ? 'active' : '' }}">
                            <span class="nav-icon">▣</span>
                            Data Fasilitas
                        </a>

                    {{-- ADMIN FASILITAS --}}
                    @elseif (auth()->user()->role?->nama_role === 'admin_fasilitas')

                        <a href="{{ route('dashboard.admin') }}"
                           class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                            <span class="nav-icon">⌂</span>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.fasilitas.index') }}"
                           class="nav-link {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
                            <span class="nav-icon">▣</span>
                            Kelola Fasilitas
                        </a>

                        <a href="{{ route('admin.peminjaman.index') }}"
                           class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                            <span class="nav-icon">▤</span>
                            Pengajuan Peminjaman
                        </a>

                    {{-- PEMINJAM --}}
                    @elseif (auth()->user()->role?->nama_role === 'peminjam')

                        <a href="{{ route('dashboard.peminjam') }}"
                           class="nav-link {{ request()->routeIs('dashboard.peminjam') ? 'active' : '' }}">
                            <span class="nav-icon">⌂</span>
                            Dashboard
                        </a>

                        <a href="{{ route('peminjam.peminjaman.index') }}"
                           class="nav-link {{ request()->routeIs('peminjam.peminjaman.index') ? 'active' : '' }}">
                            <span class="nav-icon">▤</span>
                            Peminjaman Saya
                        </a>

                        <a href="{{ route('peminjam.peminjaman.riwayat') }}"
                           class="nav-link {{ request()->routeIs('peminjam.peminjaman.riwayat') ? 'active' : '' }}">
                            <span class="nav-icon">◷</span>
                            Riwayat Peminjaman
                        </a>

                    @endif

                </nav>

                <div class="sidebar-bottom">

                    <div class="sidebar-help">
                        <span class="help-icon">?</span>

                        <div>
                            <strong>Butuh bantuan?</strong>
                            <small>Hubungi pengelola sistem.</small>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="nav-link logout-button">
                            <span class="nav-icon">↪</span>
                            Keluar
                        </button>
                    </form>

                </div>

            </aside>

            <div class="main-area">

                <header class="topbar">

                    <button type="button"
                            class="menu-toggle"
                            id="menuToggle"
                            aria-label="Buka menu">
                        ☰
                    </button>

                    <div class="topbar-heading">
                        <span class="topbar-eyebrow">SISTEM INFORMASI</span>
                        <span class="topbar-title">Peminjaman Fasilitas</span>
                    </div>

                    <div class="user-info">

                        <div class="avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="user-text">
                            <strong>{{ auth()->user()->name }}</strong>

                            <small>
                                {{ str_replace('_', ' ', auth()->user()->role?->nama_role ?? 'Pengguna') }}
                            </small>
                        </div>

                    </div>

                </header>

                <main class="page-content">

                    <div class="page-heading">

                        <div>
                            <h1>@yield('page-title', 'Dashboard')</h1>

                            <p>
                                @yield('page-description', 'Selamat datang di sistem peminjaman fasilitas.')
                            </p>
                        </div>

                        <div class="page-date" id="currentDate"></div>

                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            <span>✓</span>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-error">
                            <span>!</span>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error">
                            <span>!</span>

                            <div>
                                <strong>Periksa kembali data yang dimasukkan.</strong>

                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
                        </div>
                    @endif

                    @yield('content')

                    <footer class="footer">
                        &copy; {{ date('Y') }} FasilitasKu.
                        Sistem Informasi Peminjaman Fasilitas.
                    </footer>

                </main>

            </div>

        </div>

    @else

        <main class="auth-shell">
            @yield('content')
        </main>

    @endauth
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>
