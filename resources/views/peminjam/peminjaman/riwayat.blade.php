
@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman | Fasilitasku')

@section('content')

<section class="user-panel user-riwayat-page">

    <div class="user-panel-heading">
        <div>
            <span class="user-hero-eyebrow">AKTIVITAS AKUN</span>
            <h1>Riwayat Peminjaman</h1>
            <p>
                Pantau seluruh pengajuan fasilitas yang pernah kamu lakukan,
                mulai dari pengajuan baru hingga selesai.
            </p>
        </div>

        <a href="{{ route('dashboard.peminjam') }}#fasilitas"
           class="user-facility-button">
            Cari Fasilitas →
        </a>
    </div>

    @if (session('success'))
        <div class="user-riwayat-alert">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="user-riwayat-summary">
        <div>
            <span>Total Riwayat</span>
            <strong>{{ $peminjaman->total() }}</strong>
        </div>

        <div>
            <span>Halaman</span>
            <strong>{{ $peminjaman->currentPage() }}</strong>
        </div>
    </div>

    <div class="user-riwayat-heading">
        <div>
            <h2>Aktivitas Peminjaman</h2>
            <p>Informasi jadwal, biaya, dan status setiap pengajuan.</p>
        </div>
    </div>

    <div class="user-riwayat-list">

        @forelse ($peminjaman as $item)

            <article class="user-riwayat-card">

                <div class="user-riwayat-card-icon">
                    @if ($item->fasilitas && $item->fasilitas->foto)
                        <img
                            src="{{ asset('storage/' . $item->fasilitas->foto) }}"
                            alt="{{ $item->fasilitas->nama_fasilitas }}">
                    @else
                        <span>⌂</span>
                    @endif
                </div>

                <div class="user-riwayat-card-content">

                    <div class="user-riwayat-card-top">
                        <div>
                            <span class="user-riwayat-label">
                                PENGAJUAN PEMINJAMAN
                            </span>

                            <h3>
                                {{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas tidak tersedia' }}
                            </h3>

                            <p class="user-riwayat-instansi">
                                {{ $item->fasilitas->instansi->nama_instansi ?? 'Instansi tidak tersedia' }}
                            </p>
                        </div>

                        <span class="user-peminjaman-status status-{{ $item->status }}">
                            <span class="user-peminjaman-status-dot"></span>
                            {{ ucwords(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </div>

                    <div class="user-riwayat-details">

                        <div>
                            <span class="user-riwayat-detail-label">
                                Waktu Mulai
                            </span>

                            <strong>
                                {{ $item->waktu_mulai
                                    ? \Carbon\Carbon::parse($item->waktu_mulai)->format('d M Y, H:i')
                                    : '-' }}
                            </strong>
                        </div>

                        <div>
                            <span class="user-riwayat-detail-label">
                                Waktu Selesai
                            </span>

                            <strong>
                                {{ $item->waktu_selesai
                                    ? \Carbon\Carbon::parse($item->waktu_selesai)->format('d M Y, H:i')
                                    : '-' }}
                            </strong>
                        </div>

                        <div>
                            <span class="user-riwayat-detail-label">
                                Total Biaya
                            </span>

                            <strong class="user-riwayat-price">
                                Rp{{ number_format((float) ($item->total_biaya ?? 0), 0, ',', '.') }}
                            </strong>
                        </div>

                        <div>
                            <span class="user-riwayat-detail-label">
                                Tanggal Pengajuan
                            </span>

                            <strong>
                                {{ $item->created_at
                                    ? $item->created_at->format('d M Y')
                                    : '-' }}
                            </strong>
                        </div>

                    </div>

                </div>

            </article>

        @empty

            <div class="user-riwayat-empty">
                <div class="user-riwayat-empty-icon">▤</div>

                <h3>Belum Ada Riwayat Peminjaman</h3>

                <p>
                    Pengajuan yang kamu buat akan tercatat di halaman ini.
                    Temukan fasilitas yang sesuai dengan kebutuhanmu untuk memulai.
                </p>

                <a href="{{ route('dashboard.peminjam') }}#fasilitas"
                   class="user-facility-button">
                    Jelajahi Fasilitas →
                </a>
            </div>

        @endforelse

    </div>

    @if ($peminjaman->hasPages())
        <div class="user-riwayat-pagination">
            <span>
                Menampilkan {{ $peminjaman->firstItem() }}–{{ $peminjaman->lastItem() }}
                dari {{ $peminjaman->total() }} pengajuan
            </span>

            {{ $peminjaman->links() }}
        </div>
    @endif

</section>

@endsection
