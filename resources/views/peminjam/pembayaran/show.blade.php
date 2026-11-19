
@extends('layouts.peminjam')

@section('title', 'Pembayaran | Fasilitasku')

@section('content')

@php
    $pembayaran = $peminjaman->pembayaran;
    $jumlahBayar = (float) $pembayaran->jumlah_bayar;
@endphp

<section class="user-panel">

    {{-- HEADER HALAMAN --}}
    <div class="mb-4">
        <span class="user-hero-eyebrow">LAYANAN FASILITAS PUBLIK</span>

        <h1 class="mt-2 mb-2">Pembayaran Peminjaman</h1>

        <p class="text-muted mb-3">
            Selesaikan pembayaran untuk mengonfirmasi peminjaman fasilitas.
        </p>

        <a href="{{ route('peminjam.peminjaman.index') }}"
           class="user-facility-button d-inline-flex">
            ← Kembali
        </a>
    </div>

    {{-- KONTEN PEMBAYARAN --}}
    <div class="row justify-content-center">
        <div class="col-12 col-xl-9">

            {{-- NOTIFIKASI BERHASIL --}}
            @if(session('success'))
                <div class="user-peminjaman-alert mb-3">
                    ✓ {{ session('success') }}
                </div>
            @endif

            {{-- NOTIFIKASI ERROR --}}
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <strong>Terjadi kesalahan:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- RINCIAN TAGIHAN --}}
            <div class="panel mb-4">

                <div class="panel-header">
                    <div>
                        <h2>Rincian Tagihan</h2>
                        <p>Informasi biaya pengajuan peminjaman.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <tbody>
                            <tr>
                                <th>Nomor Pengajuan</th>
                                <td>#{{ $peminjaman->id }}</td>
                            </tr>

                            <tr>
                                <th>Nama Fasilitas</th>
                                <td>
                                    {{ $peminjaman->fasilitas->nama_fasilitas ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Instansi</th>
                                <td>
                                    {{ $peminjaman->fasilitas->instansi->nama_instansi ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Waktu Mulai</th>
                                <td>
                                    {{ $peminjaman->waktu_mulai?->format('d-m-Y H:i') ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Waktu Selesai</th>
                                <td>
                                    {{ $peminjaman->waktu_selesai?->format('d-m-Y H:i') ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Total Pembayaran</th>
                                <td>
                                    <strong class="user-peminjaman-price">
                                        Rp{{ number_format($jumlahBayar, 0, ',', '.') }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- REKENING TUJUAN --}}
            <div class="panel mb-4">

                <div class="panel-header">
                    <div>
                        <h2>Rekening Tujuan</h2>
                        <p>Informasi rekening untuk simulasi pembayaran.</p>
                    </div>

                    <span class="badge bg-info text-dark">SIMULASI</span>
                </div>

                <div class="alert alert-warning">
                    <strong>Perhatian:</strong>
                    Informasi rekening ini hanya untuk demonstrasi aplikasi.
                    Jangan melakukan transfer uang sungguhan.
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <tbody>
                            <tr>
                                <th>Bank</th>
                                <td>BANK SIMULASI</td>
                            </tr>

                            <tr>
                                <th>Nomor Rekening</th>
                                <td>
                                    <strong>1234567890</strong>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            onclick="salinRekening()">
                                        <i class="bi bi-copy"></i>
                                        Salin
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <th>Atas Nama</th>
                                <td>FASILITASKU</td>
                            </tr>

                            <tr>
                                <th>Jumlah Transfer</th>
                                <td>
                                    <strong>
                                        Rp{{ number_format($jumlahBayar, 0, ',', '.') }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STATUS PEMBAYARAN --}}
            <div class="panel mb-4">

                <div class="panel-header">
                    <div>
                        <h2>Status Pembayaran</h2>
                        <p>Pantau proses pembayaran pengajuanmu.</p>
                    </div>
                </div>

                @if($pembayaran->status === 'belum_bayar')

                    <div class="alert alert-warning mb-0">
                        <strong>Menunggu Pembayaran</strong>
                        <p class="mb-0 mt-1">
                            Silakan lengkapi pembayaran simulasi dan unggah bukti pembayaran.
                        </p>
                    </div>

                @elseif($pembayaran->status === 'menunggu_verifikasi')

                    <div class="alert alert-info mb-0">
                        <strong>Menunggu Verifikasi Admin</strong>
                        <p class="mb-0 mt-1">
                            Bukti pembayaran sudah dikirim dan sedang diperiksa oleh admin.
                        </p>
                    </div>

                @elseif($pembayaran->status === 'terverifikasi')

                    <div class="alert alert-success mb-0">
                        <strong>✓ Pembayaran Terverifikasi</strong>
                        <p class="mb-0 mt-1">
                            Pembayaran telah diverifikasi dan peminjaman telah dikonfirmasi.
                        </p>
                    </div>

                @elseif($pembayaran->status === 'ditolak')

                    <div class="alert alert-danger mb-0">
                        <strong>Bukti Pembayaran Ditolak</strong>
                        <p class="mb-0 mt-1">
                            {{ $pembayaran->catatan_admin ?: 'Silakan unggah ulang bukti pembayaran.' }}
                        </p>
                    </div>

                @endif

                {{-- BUKTI PEMBAYARAN SEBELUMNYA --}}
                @if($pembayaran->bukti_pembayaran)
                    <div class="mt-3">
                        <p class="mb-1">
                            <strong>Bukti pembayaran sebelumnya:</strong>
                        </p>

                        <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}"
                           target="_blank"
                           rel="noopener">
                            Lihat Bukti Pembayaran ↗
                        </a>
                    </div>
                @endif

            </div>

            {{-- FORM UNGGAH BUKTI --}}
            @if($peminjaman->status === 'menunggu_pembayaran'
                && in_array($pembayaran->status, ['belum_bayar', 'ditolak']))

                <div class="panel">

                    <div class="panel-header">
                        <div>
                            <h2>Unggah Bukti Pembayaran</h2>
                            <p>Unggah dokumen bukti pembayaran untuk diperiksa admin.</p>
                        </div>
                    </div>

                    <form action="{{ route('peminjam.pembayaran.store', $peminjaman->id) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="formPembayaran">

                        @csrf

                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">
                                Bukti Pembayaran
                            </label>

                            <input type="file"
                                   name="bukti_pembayaran"
                                   id="bukti_pembayaran"
                                   class="form-control"
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   required>

                            <small class="text-muted">
                                Format JPG, JPEG, PNG, atau PDF. Maksimal 5 MB.
                            </small>
                        </div>

                        <button type="button"
                                class="btn btn-primary"
                                id="btnKirimPembayaran">
                            <i class="bi bi-send me-1"></i>
                            Kirim Bukti Pembayaran
                        </button>

                    </form>

                </div>

            @endif

        </div>
    </div>

</section>

@endsection

{{-- SWEETALERT2 --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // KONFIRMASI KIRIM BUKTI PEMBAYARAN
        const tombolKirim = document.getElementById('btnKirimPembayaran');
        const formPembayaran = document.getElementById('formPembayaran');
        const inputBukti = document.getElementById('bukti_pembayaran');

        if (tombolKirim && formPembayaran && inputBukti) {

            tombolKirim.addEventListener('click', function () {

                if (!inputBukti.files.length) {
                    inputBukti.reportValidity();
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Pembayaran',

                    html: `
                        <p class="mb-2">
                            Apakah kamu yakin ingin mengirim bukti pembayaran ini?
                        </p>
                        <p class="text-muted small mb-0">
                            Pastikan dokumen yang dipilih sudah benar.
                            Bukti pembayaran akan diteruskan kepada admin
                            untuk diverifikasi.
                        </p>
                    `,

                    icon: 'question',

                    showCancelButton: true,

                    confirmButtonText: 'Ya, Kirim Bukti',
                    cancelButtonText: 'Periksa Kembali',

                    confirmButtonColor: '#24527A',
                    cancelButtonColor: '#6c757d',

                    reverseButtons: true,
                    focusCancel: true,

                    customClass: {
                        popup: 'rounded-4',
                        confirmButton: 'rounded-3 px-4',
                        cancelButton: 'rounded-3 px-4'
                    }
                }).then((result) => {

                    if (result.isConfirmed) {
                        formPembayaran.submit();
                    }

                });

            });

        }

    });

    // SALIN NOMOR REKENING
    function salinRekening() {

        const nomorRekening = '1234567890';

        if (navigator.clipboard && window.isSecureContext) {

            navigator.clipboard.writeText(nomorRekening)
                .then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Nomor rekening berhasil disalin',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menyalin',
                        text: 'Silakan salin nomor rekening secara manual.'
                    });
                });

        } else {

            Swal.fire({
                icon: 'info',
                title: 'Salin nomor rekening',
                text: nomorRekening
            });

        }

    }
</script>
@endpush
