
@extends('layouts.app')

@section('title', 'Dashboard Admin Fasilitas')
@section('page-title', 'Dashboard Admin Fasilitas')
@section('page-description', 'Kelola fasilitas instansi dan proses pengajuan peminjaman.')

@section('content')

    {{-- SAPAAN ADMIN --}}
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Selamat datang, {{ $user->name }}!</h2>
                <p>
                    Kelola fasilitas dan pantau permohonan peminjaman
                    yang masuk ke instansi Anda.
                </p>
            </div>

            <div class="stat-icon">⌂</div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="stats-grid">

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Total Fasilitas</span>
                <h3>{{ $totalFasilitas }}</h3>
                <small>Seluruh fasilitas instansi</small>
            </div>
            <div class="stat-icon">▣</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Fasilitas Aktif</span>
                <h3>{{ $fasilitasAktif }}</h3>
                <small>Fasilitas yang tersedia</small>
            </div>
            <div class="stat-icon">✓</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Menunggu Persetujuan</span>
                <h3>{{ $pengajuanMenunggu }}</h3>
                <small>Pengajuan yang perlu diproses</small>
            </div>
            <div class="stat-icon">◷</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Peminjaman Disetujui</span>
                <h3>{{ $totalPeminjamanDisetujui }}</h3>
                <small>Pengajuan yang telah disetujui atau diproses</small>
            </div>
            <div class="stat-icon">✓</div>
        </div>

    </section>

    {{-- AKSES CEPAT --}}
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Akses Cepat</h2>
                <p>Pilih aktivitas yang ingin Anda lakukan.</p>
            </div>
        </div>

        <div class="quick-actions">

            <a href="{{ route('admin.fasilitas.index') }}" class="quick-action">
                <div class="stat-icon">▣</div>
                <div>
                    <strong>Kelola Fasilitas</strong>
                    <p>Tambah, ubah, dan kelola fasilitas instansi.</p>
                </div>
            </a>

            <a href="{{ route('admin.peminjaman.index') }}" class="quick-action">
                <div class="stat-icon">▤</div>
                <div>
                    <strong>Pengajuan Peminjaman</strong>
                    <p>Periksa dan proses permohonan peminjaman.</p>
                </div>
            </a>

        </div>
    </section>

    {{-- PENGAJUAN TERBARU --}}
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Pengajuan Peminjaman Terbaru</h2>
                <p>Daftar permohonan terbaru dari peminjam.</p>
            </div>

            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-primary">
                Lihat Semua
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Peminjam</th>
                        <th>Fasilitas</th>
                        <th>Waktu Mulai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pengajuanTerbaru as $item)

                        @php
                            $statusClass = match ($item->status) {
                                'diajukan' => 'warning',
                                'perlu_perbaikan' => 'info',
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                'menunggu_pembayaran' => 'primary',
                                'menunggu_verifikasi_pembayaran' => 'primary',
                                'dikonfirmasi' => 'success',
                                'selesai' => 'secondary',
                                'dibatalkan' => 'secondary',
                                default => 'secondary',
                            };
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->user->name ?? 'Pengguna tidak ditemukan' }}
                            </td>

                            <td>
                                {{ $item->fasilitas->nama_fasilitas ?? '-' }}
                            </td>

                            <td>
                                {{ $item->waktu_mulai->format('d-m-Y H:i') }}
                            </td>

                            <td>
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucwords(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('admin.peminjaman.show', $item->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <div class="stat-icon" style="margin: 0 auto 15px;">
                                        ▤
                                    </div>

                                    <strong>Belum Ada Pengajuan</strong>

                                    <p>
                                        Pengajuan peminjaman dari pengguna
                                        akan ditampilkan di sini.
                                    </p>
                                </div>
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- FASILITAS TERBARU --}}
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Fasilitas Instansi</h2>
                <p>Daftar fasilitas terbaru yang dikelola instansi Anda.</p>
            </div>

            <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-primary">
                Kelola Semua
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Fasilitas</th>
                        <th>Tarif</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($fasilitas as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->nama_fasilitas }}</td>

                            <td>
                                Rp{{ number_format((float) $item->tarif, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($item->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada fasilitas yang ditambahkan.
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

@endsection
