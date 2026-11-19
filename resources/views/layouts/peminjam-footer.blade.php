
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
