
@extends('layouts.peminjam')

@section('title', 'Ajukan Peminjaman | Fasilitasku')

@section('content')

<section class="user-create-page">

    <a href="{{ route('peminjam.fasilitas.show', $fasilitas->id) }}"
       class="user-create-back">
        ← Kembali ke Detail Fasilitas
    </a>

    <div class="user-create-card">

        <div class="user-create-heading">
            <span class="user-create-eyebrow">PEMINJAMAN FASILITAS PUBLIK</span>
            <h1>Ajukan Peminjaman</h1>
            <p>
                Lengkapi jadwal penggunaan fasilitas yang kamu pilih
                untuk mengirimkan pengajuan kepada pengelola.
            </p>
        </div>

        @if ($errors->any())
            <div class="user-create-error">
                <strong>Periksa kembali data berikut:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                    FASILITAS YANG DIPILIH
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

        <form
            action="{{ route('peminjam.peminjaman.store', $fasilitas->id) }}"
            method="POST">

            @csrf

            <div class="user-create-section-title">
                <div class="user-create-section-icon">◷</div>

                <div>
                    <h2>Jadwal Peminjaman</h2>
                    <p>Tentukan waktu mulai dan selesai penggunaan fasilitas.</p>
                </div>
            </div>

            <div class="user-create-form-grid">

                <div class="user-create-field">
                    <label for="waktu_mulai">
                        Tanggal dan Waktu Mulai
                        <span>*</span>
                    </label>

                    <input
                        id="waktu_mulai"
                        name="waktu_mulai"
                        type="datetime-local"
                        value="{{ old('waktu_mulai') }}"
                        min="{{ now()->addMinute()->format('Y-m-d\TH:i') }}"
                        required>

                    @error('waktu_mulai')
                        <small class="user-create-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                    <small>Pilih waktu dimulainya kegiatan.</small>
                </div>

                <div class="user-create-field">
                    <label for="waktu_selesai">
                        Tanggal dan Waktu Selesai
                        <span>*</span>
                    </label>

                    <input
                        id="waktu_selesai"
                        name="waktu_selesai"
                        type="datetime-local"
                        value="{{ old('waktu_selesai') }}"
                        min="{{ old('waktu_mulai', now()->addMinute()->format('Y-m-d\TH:i')) }}"
                        required>

                    @error('waktu_selesai')
                        <small class="user-create-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                    <small>Waktu selesai harus setelah waktu mulai.</small>
                </div>

            </div>

            <div class="user-create-notice">
                <span class="user-create-notice-icon">i</span>

                <div>
                    <strong>Informasi Pengajuan</strong>
                    <p>
                        Pengajuan akan diperiksa oleh pengelola fasilitas.
                        Pengiriman formulir tidak berarti peminjaman sudah
                        disetujui atau fasilitas sudah dipesan.
                    </p>
                </div>
            </div>

            <div class="user-create-actions">
                <a href="{{ route('peminjam.fasilitas.show', $fasilitas->id) }}"
                   class="user-create-cancel">
                    Batal
                </a>

                <button type="submit" class="user-create-submit">
                    Kirim Pengajuan →
                </button>
            </div>

        </form>

    </div>

</section>

@endsection
