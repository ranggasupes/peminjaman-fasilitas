
@extends('layouts.peminjam')

@section('title', 'Dashboard Peminjam | Fasilitasku')

@section('content')

{{-- Hero --}}
<section class="user-hero">
    <div class="user-hero-content">
        <span class="user-hero-eyebrow">
            LAYANAN FASILITAS PUBLIK
        </span>

        <h1>Temukan fasilitas terbaik untuk kegiatanmu.</h1>

        <p>
            Cari fasilitas, lihat lokasi dan tarif, lalu ajukan
            peminjaman dengan lebih mudah dalam satu platform.
        </p>

        <form
            class="user-search-form"
            id="facility-search-form"
            action="{{ route('dashboard.peminjam') }}"
            method="GET">

            <input
                type="search"
                id="facility-search"
                name="cari"
                value="{{ request('cari') }}"
                placeholder="Cari gedung, lapangan, ruang rapat..."
                aria-label="Cari fasilitas">

            <button type="submit">
                Cari Fasilitas →
            </button>
        </form>
    </div>
</section>

{{-- Statistik dan Daftar Fasilitas --}}
<div class="user-dashboard-layout">
    <div class="user-main-column">

        {{-- Statistik --}}
        <section class="user-stats">

            <article class="user-stat-card">
                <div class="user-stat-icon stat-green">⌂</div>

                <div>
                    <p>Fasilitas Ditampilkan</p>
                    <h2>{{ $totalFasilitas }}</h2>
                    <span>Fasilitas aktif yang tersedia</span>
                </div>
            </article>

            <article class="user-stat-card">
                <div class="user-stat-icon stat-orange">◷</div>

                <div>
                    <p>Pengajuan Aktif</p>
                    <h2>{{ $jumlahPengajuan }}</h2>
                    <span>Pengajuan dalam proses</span>
                </div>
            </article>

            <article class="user-stat-card">
                <div class="user-stat-icon stat-blue">▤</div>

                <div>
                    <p>Riwayat Terbaru</p>
                    <h2>{{ $peminjaman->count() }}</h2>
                    <span>Data yang ditampilkan</span>
                </div>
            </article>

        </section>

        {{-- Daftar Fasilitas --}}
        <section class="user-panel" id="fasilitas">

            <div class="user-panel-heading">
                <div>
                    <h2>Jelajahi Fasilitas</h2>
                    <p>Pilih tempat yang sesuai dengan kebutuhanmu.</p>
                </div>

                <span class="user-panel-label">
                    Fasilitas Publik
                </span>
            </div>

            <div class="user-facility-grid" id="facility-grid">

                @forelse ($fasilitas as $item)

                    <article
                        class="user-facility-card"
                        data-facility-name="{{ strtolower($item->nama_fasilitas . ' ' . ($item->instansi->nama_instansi ?? '') . ' ' . ($item->lokasi ?? '')) }}">

                        {{-- Foto Fasilitas --}}
                        @if ($item->foto)
                            <img
                                class="user-facility-image"
                                src="{{ asset('storage/' . $item->foto) }}"
                                alt="{{ $item->nama_fasilitas }}"
                                loading="lazy">
                        @else
                            <div class="user-facility-image-placeholder">
                                <span>⌂</span>
                                <small>Foto belum tersedia</small>
                            </div>
                        @endif

                        <div class="user-facility-content">

                            <span class="user-facility-category">
                                Fasilitas Publik
                            </span>

                            <h3>{{ $item->nama_fasilitas }}</h3>

                            <p class="user-facility-owner">
                                🏢 {{ $item->instansi->nama_instansi ?? 'Instansi belum tersedia' }}
                            </p>

                            <p class="user-facility-location">
                                📍 {{ $item->lokasi ?: 'Lokasi belum diisi' }}
                            </p>

                            <div class="user-facility-price">
                                Rp {{ number_format((float) ($item->tarif ?? 0), 0, ',', '.') }}
                                <small>/ tarif terdaftar</small>
                            </div>

                            <a
                                href="{{ route('peminjam.fasilitas.show', $item->id) }}"
                                class="user-facility-button">
                                Lihat Fasilitas <span>→</span>
                            </a>

                        </div>
                    </article>

                @empty

                    <div class="user-empty-state">
                        <div class="user-empty-icon">⌂</div>

                        <h3>Belum ada fasilitas tersedia</h3>

                        <p>
                            Fasilitas yang diaktifkan pengelola akan muncul di sini.
                        </p>
                    </div>

                @endforelse

            </div>

            {{-- Pesan ketika hasil pencarian kosong --}}
            <div
                class="user-search-empty"
                id="facility-search-empty"
                hidden>
                Fasilitas yang kamu cari tidak ditemukan.
            </div>

            {{-- Pagination --}}
            @if ($fasilitas->hasPages())
                <div class="user-facility-pagination">
                    {{ $fasilitas->onEachSide(1)->links() }}
                </div>
            @endif

        </section>

    </div>
</div>

@endsection
