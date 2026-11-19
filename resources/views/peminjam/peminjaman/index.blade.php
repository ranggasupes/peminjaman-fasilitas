
@extends('layouts.peminjam')

@section('title', 'Peminjaman Saya | Fasilitasku')

@section('content')

<section class="user-panel user-peminjaman-page">

    <div class="user-panel-heading">
        <div>
            <span class="user-hero-eyebrow">LAYANAN FASILITAS PUBLIK</span>
            <h1>Peminjaman Saya</h1>
            <p>Kelola dan pantau pengajuan peminjaman fasilitasmu.</p>
        </div>

        <a href="{{ route('dashboard.peminjam') }}#fasilitas"
           class="user-facility-button">
            + Ajukan Peminjaman
        </a>
    </div>

    @php
        $totalPengajuan = $peminjaman->total();

        $jumlahDiproses = $peminjaman->getCollection()
            ->whereIn('status', [
                'diajukan',
                'perlu_perbaikan',
                'menunggu_pembayaran',
                'menunggu_verifikasi_pembayaran'
            ])->count();

        $jumlahDisetujui = $peminjaman->getCollection()
            ->whereIn('status', ['disetujui', 'dikonfirmasi'])
            ->count();

        $jumlahSelesai = $peminjaman->getCollection()
            ->where('status', 'selesai')
            ->count();
    @endphp

    <div class="user-peminjaman-stats">
        <article class="user-peminjaman-stat">
            <div class="user-peminjaman-stat-icon stat-green">▤</div>
            <div>
                <span>Total Pengajuan</span>
                <h2>{{ $totalPengajuan }}</h2>
            </div>
        </article>

        <article class="user-peminjaman-stat">
            <div class="user-peminjaman-stat-icon stat-orange">◷</div>
            <div>
                <span>Dalam Proses</span>
                <h2>{{ $jumlahDiproses }}</h2>
            </div>
        </article>

        <article class="user-peminjaman-stat">
            <div class="user-peminjaman-stat-icon stat-blue">✓</div>
            <div>
                <span>Disetujui</span>
                <h2>{{ $jumlahDisetujui }}</h2>
            </div>
        </article>

        <article class="user-peminjaman-stat">
            <div class="user-peminjaman-stat-icon stat-green">★</div>
            <div>
                <span>Selesai</span>
                <h2>{{ $jumlahSelesai }}</h2>
            </div>
        </article>
    </div>

    @if(session('success'))
        <div class="user-peminjaman-alert">
            <span>✓</span>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="user-peminjaman-toolbar">
        <div>
            <h2>Daftar Pengajuan</h2>
            <p>Informasi peminjaman yang terhubung dengan akunmu.</p>
        </div>

        <span class="user-peminjaman-total">
            {{ $totalPengajuan }} pengajuan
        </span>
    </div>

    <div class="user-peminjaman-table-wrapper">
        <table class="user-peminjaman-table">
            <thead>
                <tr>
                    <th>Fasilitas</th>
                    <th>Waktu Peminjaman</th>
                    <th>Total Biaya</th>
                    <th>Status Pengajuan</th>
                    <th>Tindakan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjaman as $item)
                    <tr>
                        <td>
                            <div class="user-peminjaman-facility">
                                <div class="user-peminjaman-facility-icon">
                                    @if($item->fasilitas && $item->fasilitas->foto)
                                        <img
                                            src="{{ asset('storage/' . $item->fasilitas->foto) }}"
                                            alt="{{ $item->fasilitas->nama_fasilitas }}">
                                    @else
                                        <span>⌂</span>
                                    @endif
                                </div>

                                <div>
                                    <strong>
                                        {{ $item->fasilitas->nama_fasilitas ?? 'Fasilitas tidak tersedia' }}
                                    </strong>

                                    <small>
                                        {{ $item->fasilitas->instansi->nama_instansi ?? 'Instansi tidak tersedia' }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="user-peminjaman-date">
                                <span>
                                    Mulai:
                                    {{ $item->waktu_mulai
                                        ? \Carbon\Carbon::parse($item->waktu_mulai)->format('d M Y, H:i')
                                        : '-' }}
                                </span>

                                <span>
                                    Selesai:
                                    {{ $item->waktu_selesai
                                        ? \Carbon\Carbon::parse($item->waktu_selesai)->format('d M Y, H:i')
                                        : '-' }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <strong class="user-peminjaman-price">
                                Rp{{ number_format((float) ($item->total_biaya ?? 0), 0, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                            <span class="user-peminjaman-status status-{{ $item->status }}">
                                <span class="user-peminjaman-status-dot"></span>
                                {{ ucwords(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>

                        <td>
                            @if($item->status === 'menunggu_pembayaran')
                                <a href="{{ route('peminjam.pembayaran.show', $item->id) }}"
                                   class="user-facility-button">
                                    Bayar Sekarang
                                </a>

                            @elseif($item->status === 'menunggu_verifikasi_pembayaran')
                                <a href="{{ route('peminjam.pembayaran.show', $item->id) }}"
                                   class="user-facility-button">
                                    Lihat Pembayaran
                                </a>

                            @elseif($item->status === 'dikonfirmasi')
                                <span class="text-success">
                                    ✓ Dikonfirmasi
                                </span>

                            @elseif($item->status === 'selesai')
                                <span class="text-success">
                                    ✓ Selesai
                                </span>

                            @elseif($item->status === 'perlu_perbaikan')
                                <span class="text-warning">
                                    Perlu diperbaiki
                                </span>

                            @elseif($item->status === 'ditolak')
                                <span class="text-danger">
                                    Pengajuan ditolak
                                </span>

                            @elseif($item->status === 'dibatalkan')
                                <span class="text-muted">
                                    Dibatalkan
                                </span>

                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5">
                            <div class="user-peminjaman-empty">
                                <div class="user-peminjaman-empty-icon">▤</div>

                                <h3>Belum Ada Pengajuan</h3>

                                <p>
                                    Kamu belum memiliki pengajuan peminjaman.
                                    Yuk, temukan fasilitas yang sesuai dengan kebutuhanmu.
                                </p>

                                <a href="{{ route('dashboard.peminjam') }}#fasilitas"
                                   class="user-facility-button">
                                    Jelajahi Fasilitas →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($peminjaman->hasPages())
        <div class="user-peminjaman-pagination">
            <span>
                Menampilkan {{ $peminjaman->firstItem() }}–{{ $peminjaman->lastItem() }}
                dari {{ $peminjaman->total() }} pengajuan
            </span>

            {{ $peminjaman->links() }}
        </div>
    @endif

</section>

@endsection
