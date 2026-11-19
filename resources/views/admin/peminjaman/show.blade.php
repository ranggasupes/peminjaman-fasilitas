
@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Peminjaman')
@section('page-description', 'Periksa informasi pengajuan sebelum memberikan keputusan.')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">
        ← Kembali
    </a>
</div>

<section class="panel">
    <div class="panel-header">
        <div>
            <h2>Informasi Pengajuan #{{ $peminjaman->id }}</h2>
            <p>Detail permohonan peminjaman fasilitas.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <th>Nama Peminjam</th>
                    <td>{{ $peminjaman->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Fasilitas</th>
                    <td>{{ $peminjaman->fasilitas->nama_fasilitas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Instansi</th>
                    <td>{{ $peminjaman->fasilitas->instansi->nama_instansi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Waktu Mulai</th>
                    <td>{{ $peminjaman->waktu_mulai?->format('d-m-Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Waktu Selesai</th>
                    <td>{{ $peminjaman->waktu_selesai?->format('d-m-Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Biaya</th>
                    <td>Rp{{ number_format((float) $peminjaman->total_biaya, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Catatan Peminjam</th>
                    <td>{{ $peminjaman->catatan_peminjam ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucwords(str_replace('_', ' ', $peminjaman->status)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($peminjaman->catatan_admin)
        <div class="alert alert-info">
            <strong>Catatan Admin:</strong>
            <p class="mb-0">{{ $peminjaman->catatan_admin }}</p>
        </div>
    @endif
</section>

{{-- KEPUTUSAN PENGAJUAN --}}
@if($peminjaman->status === 'diajukan')

<section class="panel mt-4">
    <div class="panel-header">
        <div>
            <h2>Keputusan Admin</h2>
            <p>Tentukan hasil pemeriksaan pengajuan ini.</p>
        </div>
    </div>

    {{-- TERIMA PENGAJUAN --}}
    <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}"
          method="POST"
          class="mb-4"
          data-swal-confirm
          data-swal-title="Terima Pengajuan?"
          data-swal-text="Pengajuan ini akan disetujui dan peminjam dapat melanjutkan ke tahap pembayaran."
          data-swal-icon="question"
          data-swal-confirm-text="Ya, Terima Pengajuan">
        @csrf
        @method('PATCH')

        <button type="submit" class="btn btn-success">
            ✓ Terima Pengajuan
        </button>
    </form>

    <hr>

    {{-- TOLAK PENGAJUAN --}}
    <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}"
          method="POST"
          class="mb-4"
          data-swal-confirm
          data-swal-title="Tolak Pengajuan?"
          data-swal-text="Pengajuan ini akan ditolak. Pastikan alasan penolakan sudah diisi."
          data-swal-icon="warning"
          data-swal-confirm-text="Ya, Tolak Pengajuan">
        @csrf
        @method('PATCH')

        <label class="form-label">Alasan Penolakan</label>
        <textarea name="catatan_admin"
                  class="form-control"
                  rows="3"
                  maxlength="2000"
                  required
                  placeholder="Tuliskan alasan penolakan...">{{ old('catatan_admin') }}</textarea>

        <button type="submit" class="btn btn-danger mt-2">
            Tolak Pengajuan
        </button>
    </form>

    <hr>

    {{-- MINTA PERBAIKAN --}}
    <form action="{{ route('admin.peminjaman.revision', $peminjaman->id) }}"
          method="POST"
          data-swal-confirm
          data-swal-title="Minta Perbaikan?"
          data-swal-text="Pengajuan akan dikembalikan kepada peminjam untuk diperbaiki."
          data-swal-icon="question"
          data-swal-confirm-text="Ya, Minta Perbaikan">
        @csrf
        @method('PATCH')

        <label class="form-label">Catatan Perbaikan</label>
        <textarea name="catatan_admin"
                  class="form-control"
                  rows="3"
                  maxlength="2000"
                  required
                  placeholder="Tuliskan hal yang harus diperbaiki...">{{ old('catatan_admin') }}</textarea>

        <button type="submit" class="btn btn-warning mt-2">
            Minta Perbaikan
        </button>
    </form>
</section>

@endif

{{-- INFORMASI PEMBAYARAN --}}
@if($peminjaman->pembayaran)

<section class="panel mt-4">
    <div class="panel-header">
        <div>
            <h2>Informasi Pembayaran</h2>
            <p>Periksa pembayaran yang dikirim oleh peminjam.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <th>Jumlah Pembayaran</th>
                    <td>
                        Rp{{ number_format((float) $peminjaman->pembayaran->jumlah_bayar, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <th>Status Pembayaran</th>
                    <td>
                        {{ ucwords(str_replace('_', ' ', $peminjaman->pembayaran->status)) }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>
                        {{ $peminjaman->pembayaran->tanggal_bayar
                            ? $peminjaman->pembayaran->tanggal_bayar->format('d-m-Y H:i')
                            : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        @if($peminjaman->pembayaran->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $peminjaman->pembayaran->bukti_pembayaran) }}"
                               target="_blank"
                               rel="noopener">
                                Lihat Bukti Pembayaran ↗
                            </a>
                        @else
                            Belum ada bukti pembayaran.
                        @endif
                    </td>
                </tr>

                @if($peminjaman->pembayaran->catatan_admin)
                    <tr>
                        <th>Catatan Verifikasi</th>
                        <td>{{ $peminjaman->pembayaran->catatan_admin }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- TINDAKAN VERIFIKASI --}}
    @if($peminjaman->status === 'menunggu_verifikasi_pembayaran'
        && $peminjaman->pembayaran->status === 'menunggu_verifikasi')

        <hr>

        <h3>Verifikasi Pembayaran</h3>
        <p>Pastikan bukti pembayaran sesuai sebelum melakukan verifikasi.</p>

        {{-- VERIFIKASI PEMBAYARAN --}}
        <form action="{{ route('admin.peminjaman.verify-payment', $peminjaman->id) }}"
              method="POST"
              class="mb-4"
              data-swal-confirm
              data-swal-title="Verifikasi Pembayaran?"
              data-swal-text="Pastikan bukti pembayaran sudah sesuai. Setelah diverifikasi, pengajuan akan dikonfirmasi."
              data-swal-icon="question"
              data-swal-confirm-text="Ya, Verifikasi">
            @csrf
            @method('PATCH')

            <button type="submit" class="btn btn-success">
                ✓ Verifikasi Pembayaran
            </button>
        </form>

        <hr>

        {{-- TOLAK PEMBAYARAN --}}
        <form action="{{ route('admin.peminjaman.reject-payment', $peminjaman->id) }}"
              method="POST"
              data-swal-confirm
              data-swal-title="Tolak Bukti Pembayaran?"
              data-swal-text="Bukti pembayaran akan ditolak. Pastikan alasan penolakan sudah diisi."
              data-swal-icon="warning"
              data-swal-confirm-text="Ya, Tolak Pembayaran">
            @csrf
            @method('PATCH')

            <label class="form-label">Alasan Penolakan Pembayaran</label>

            <textarea name="catatan_admin"
                      class="form-control"
                      rows="3"
                      maxlength="2000"
                      required
                      placeholder="Tuliskan alasan bukti pembayaran ditolak...">{{ old('catatan_admin') }}</textarea>

            <button type="submit" class="btn btn-danger mt-2">
                Tolak Bukti Pembayaran
            </button>
        </form>

    @elseif($peminjaman->pembayaran->status === 'terverifikasi')

        <div class="alert alert-success mt-3">
            ✓ Pembayaran sudah diverifikasi. Pengajuan telah dikonfirmasi.
        </div>

    @elseif($peminjaman->pembayaran->status === 'ditolak')

        <div class="alert alert-danger mt-3">
            Pembayaran ditolak. Peminjam dapat mengunggah ulang bukti pembayaran.
        </div>

    @elseif($peminjaman->pembayaran->status === 'belum_bayar')

        <div class="alert alert-warning mt-3">
            Peminjam belum mengunggah bukti pembayaran.
        </div>

    @endif
</section>

@endif

@if(!in_array($peminjaman->status, ['diajukan', 'menunggu_verifikasi_pembayaran'])
    && !$peminjaman->pembayaran)

    <div class="alert alert-info mt-4">
        Pengajuan ini sudah diproses. Tidak ada tindakan yang tersedia.
    </div>

@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const confirmationForms = document.querySelectorAll('[data-swal-confirm]');

    confirmationForms.forEach(function (form) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            const title = form.dataset.swalTitle || 'Konfirmasi Tindakan';
            const message = form.dataset.swalText || 'Apakah Anda yakin ingin melanjutkan?';
            const icon = form.dataset.swalIcon || 'question';
            const confirmText = form.dataset.swalConfirmText || 'Ya, Lanjutkan';

            Swal.fire({
                title: title,
                text: message,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#24527A',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm',
                    cancelButton: 'swal-custom-cancel'
                }
            }).then(function (result) {

                if (result.isConfirmed) {
                    HTMLFormElement.prototype.submit.call(form);
                }

            });

        });

    });

});
</script>
@endpush
