
@extends('layouts.app')

@section('title', 'Pengajuan Peminjaman')
@section('page-title', 'Pengajuan Peminjaman')
@section('page-description', 'Kelola dan periksa permohonan peminjaman fasilitas instansi Anda.')

@section('content')

<section class="panel">

    <div class="panel-header">
        <div>
            <h2>Daftar Pengajuan</h2>
            <p>Seluruh permohonan peminjaman fasilitas dari pengguna.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Peminjam</th>
                    <th>Fasilitas</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjaman as $item)

                    @php
                        $statusClass = match($item->status) {
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
                        <td>{{ $loop->iteration + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}</td>

                        <td>{{ $item->user->name ?? '-' }}</td>

                        <td>{{ $item->fasilitas->nama_fasilitas ?? '-' }}</td>

                        <td>{{ $item->waktu_mulai->format('d-m-Y H:i') }}</td>

                        <td>{{ $item->waktu_selesai->format('d-m-Y H:i') }}</td>

                        <td>
                            Rp{{ number_format((float) $item->total_biaya, 0, ',', '.') }}
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
                        <td colspan="8" class="text-center">
                            <div class="empty-state">
                                <strong>Belum Ada Pengajuan</strong>
                                <p>Pengajuan peminjaman akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $peminjaman->links() }}
    </div>

</section>

@endsection
