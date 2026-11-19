
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Fasilitasku')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    @stack('styles')
</head>
<body class="user-dashboard">

<header class="user-navbar">
    <div class="user-nav-inner">

        {{-- KIRI: BRAND --}}
        <a href="{{ route('dashboard.peminjam') }}" class="user-brand">
            <div class="user-brand-icon">F</div>

            <div class="user-brand-text">
                <div class="user-brand-name">Fasilitasku</div>
                <div class="user-brand-subtitle">
                    Layanan Peminjaman Fasilitas
                </div>
            </div>
        </a>

        {{-- TENGAH: NAVIGASI --}}
        <nav class="user-nav-links">
            <a href="{{ route('dashboard.peminjam') }}"
               class="{{ request()->routeIs('dashboard.peminjam') ? 'active' : '' }}">
                <span>⌂</span> Beranda
            </a>

            <a href="{{ route('dashboard.peminjam') }}#fasilitas">
                <span>⌕</span> Cari Fasilitas
            </a>

            <a href="{{ route('peminjam.peminjaman.index') }}"
               class="{{ request()->routeIs('peminjam.peminjaman.index') ? 'active' : '' }}">
                <span>▤</span> Peminjaman Saya
            </a>

            <a href="{{ route('peminjam.peminjaman.riwayat') }}"
               class="{{ request()->routeIs('peminjam.peminjaman.riwayat') ? 'active' : '' }}">
                <span>▣</span> Riwayat
            </a>
        </nav>

        {{-- KANAN: AKUN PEMINJAM --}}
        <div class="user-nav-profile">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <span class="user-profile-name">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}"
                  method="POST"
                  class="user-logout-form">
                @csrf

                <button type="submit" class="user-logout-button">
                    Keluar
                </button>
            </form>
        </div>

    </div>
</header>

<main class="user-container">

    @if (session('success'))
        <div class="user-alert">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</main>

<footer class="user-footer">
    <div class="user-footer-container">

        <div class="user-footer-brand">
            <a href="{{ route('dashboard.peminjam') }}" class="user-footer-logo">
                <span class="user-footer-logo-icon">F</span>
                <span>Fasilitasku</span>
            </a>

            <p>
                Platform peminjaman fasilitas publik yang membantu masyarakat
                menemukan informasi fasilitas dan mengajukan peminjaman
                dengan lebih mudah.
            </p>

            <div class="user-footer-location">
                <span>⌖</span>
                <span>Kota Palu, Sulawesi Tengah</span>
            </div>
        </div>

        <div class="user-footer-column">
            <h3>Navigasi</h3>
            <a href="{{ route('dashboard.peminjam') }}">Beranda</a>
            <a href="{{ route('dashboard.peminjam') }}#fasilitas">Cari Fasilitas</a>
            <a href="{{ route('peminjam.peminjaman.index') }}">Peminjaman Saya</a>
            <a href="{{ route('peminjam.peminjaman.riwayat') }}">Riwayat Peminjaman</a>
        </div>

        <div class="user-footer-column">
            <h3>Informasi</h3>
            <a href="{{ route('dashboard.peminjam') }}#fasilitas">Daftar Fasilitas</a>
            <a href="{{ route('peminjam.peminjaman.index') }}">Status Peminjaman</a>
            <a href="{{ route('peminjam.peminjaman.index') }}">Panduan Peminjaman</a>
        </div>

        <div class="user-footer-column user-footer-contact">
            <h3>Hubungi Kami</h3>

            <p>
                Memiliki pertanyaan atau kendala saat menggunakan layanan?
            </p>

            <a href="{{ route('peminjam.peminjaman.index') }}"
               class="user-footer-contact-link">
                Pusat Bantuan <span>→</span>
            </a>

            <h4>Media Sosial</h4>

            <div class="user-footer-socials">
                <a href="https://www.instagram.com/"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Instagram"
                   title="Instagram">IG</a>

                <a href="https://www.facebook.com/"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Facebook"
                   title="Facebook">f</a>

                <a href="https://www.youtube.com/"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="YouTube"
                   title="YouTube">▶</a>
            </div>
        </div>

    </div>

    <div class="user-footer-bottom">
        <p>
            © {{ date('Y') }} Fasilitasku. Semua hak dilindungi.
        </p>

        <p>
            Layanan Peminjaman Fasilitas Publik
        </p>
    </div>
</footer>

{{-- SweetAlert2 harus dimuat sebelum script yang menggunakannya --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/app.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const logoutForm = document.querySelector('.user-logout-form');

    if (!logoutForm) return;

    logoutForm.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Keluar dari Akun?',
            text: 'Apakah kamu yakin ingin mengakhiri sesi sekarang?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
            focusCancel: true,
            allowOutsideClick: false,
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'rounded-3 px-4',
                cancelButton: 'rounded-3 px-4'
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                HTMLFormElement.prototype.submit.call(logoutForm);
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
