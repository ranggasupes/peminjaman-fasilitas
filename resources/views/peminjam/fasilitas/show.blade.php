
@extends('layouts.peminjam')

@section('title', 'Detail Fasilitas | Fasilitasku')

@section('content')

<section class="user-create-page">

    <a href="{{ route('dashboard.peminjam') }}#fasilitas"
       class="user-create-back">
        ← Kembali ke Daftar Fasilitas
    </a>

    <div class="user-create-card">

        {{-- Header --}}
        <div class="user-create-heading">
            <span class="user-create-eyebrow">
                INFORMASI FASILITAS PUBLIK
            </span>

            <h1>Detail Fasilitas</h1>

            <p>
                Lihat informasi fasilitas, instansi pengelola, lokasi,
                tarif, jadwal operasional, dan persyaratan peminjaman.
            </p>
        </div>

        {{-- Informasi utama fasilitas --}}
        <div class="user-create-facility">

            <div class="user-create-facility-image">
                @if ($fasilitas->foto)
                    <img
                        src="{{ asset('storage/' . $fasilitas->foto) }}"
                        alt="{{ $fasilitas->nama_fasilitas }}">
                @else
                    <span>⌂</span>
                @endif
            </div>

            <div class="user-create-facility-info">

                <span class="user-create-facility-label">
                    INFORMASI FASILITAS
                </span>

                <h2>{{ $fasilitas->nama_fasilitas }}</h2>

                <p>
                    {{ $fasilitas->instansi->nama_instansi ?? 'Instansi belum tersedia' }}
                </p>

                <div class="user-create-facility-meta">
                    <span>
                        📍 {{ $fasilitas->lokasi ?: 'Lokasi belum tersedia' }}
                    </span>

                    <strong>
                        Rp{{ number_format((float) ($fasilitas->tarif ?? 0), 0, ',', '.') }}
                    </strong>
                </div>

            </div>
        </div>

        <div class="user-create-divider"></div>

        {{-- Tiga informasi dalam kolom berdampingan --}}
        <div class="user-detail-grid">

            {{-- Deskripsi --}}
            <div class="user-detail-item">

                <div class="user-detail-heading">
                    <div class="user-create-section-icon">⌂</div>

                    <div>
                        <h2>Deskripsi Fasilitas</h2>
                        <p>Informasi fasilitas yang tersedia.</p>
                    </div>
                </div>

                <div class="user-detail-information">
                    <p>{{ $fasilitas->deskripsi ?: 'Belum ada deskripsi fasilitas.' }}</p>
                </div>

            </div>

            {{-- Jadwal operasional --}}
            <div class="user-detail-item">

                <div class="user-detail-heading">
                    <div class="user-create-section-icon">◷</div>

                    <div>
                        <h2>Jadwal Operasional</h2>
                        <p>Jadwal penggunaan fasilitas.</p>
                    </div>
                </div>

                <div class="user-detail-information">
                    <p>{{ $fasilitas->jadwal_operasional ?: 'Jadwal belum tersedia. Silakan hubungi pengelola.' }}</p>
                </div>

            </div>

            {{-- Persyaratan --}}
            <div class="user-detail-item">

                <div class="user-detail-heading">
                    <div class="user-create-section-icon">▤</div>

                    <div>
                        <h2>Persyaratan Peminjaman</h2>
                        <p>Ketentuan sebelum meminjam.</p>
                    </div>
                </div>

                <div class="user-detail-information">
                    <p>{{ $fasilitas->persyaratan ?: 'Persyaratan belum dicantumkan. Silakan hubungi pengelola fasilitas.' }}</p>
                </div>

            </div>

        </div>

        {{-- Informasi pengajuan --}}
        <div class="user-create-notice">
            <span class="user-create-notice-icon">i</span>

            <div>
                <strong>Informasi Peminjaman</strong>
                <p>
                    Pengajuan akan diperiksa oleh pengelola.
                    Pastikan jadwal dan persyaratan sudah sesuai.
                    Pengajuan belum dianggap disetujui sebelum mendapat
                    konfirmasi dari pengelola fasilitas.
                </p>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="user-create-actions">

            <a href="{{ route('dashboard.peminjam') }}#fasilitas"
               class="user-create-cancel">
                Kembali
            </a>

            <a href="{{ route('peminjam.peminjaman.create', $fasilitas->id) }}"
               class="user-create-submit">
                Ajukan Peminjaman →
            </a>

        </div>

    </div>

</section>

@endsection
