
@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-description', 'Kelola informasi akun dan keamanan password Anda.')

@section('content')

<style>
    .profile-wrapper {
        display: grid;
        grid-template-columns: minmax(0, 1.3fr) minmax(280px, .7fr);
        gap: 22px;
        align-items: start;
    }

    .profile-card {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 16px;
        padding: 26px;
        box-shadow: 0 4px 18px rgba(30, 55, 90, .04);
    }

    .profile-card-heading {
        margin-bottom: 24px;
    }

    .profile-card-heading h2 {
        font-size: 18px;
        color: #24364b;
        margin: 0 0 7px;
    }

    .profile-card-heading p {
        font-size: 13px;
        color: #7b8797;
        margin: 0;
    }

    .profile-avatar {
        width: 76px;
        height: 76px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #24527a, #397eae);
        color: #fff;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .profile-summary h3 {
        color: #24364b;
        font-size: 20px;
        margin: 0 0 6px;
    }

    .profile-summary p {
        color: #8290a1;
        font-size: 13px;
        margin: 0 0 18px;
        overflow-wrap: anywhere;
    }

    .profile-role {
        display: inline-block;
        background: #eaf2f9;
        color: #24527a;
        border-radius: 20px;
        padding: 7px 13px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .profile-info {
        border-top: 1px solid #edf0f4;
        margin-top: 22px;
        padding-top: 18px;
    }

    .profile-info-item {
        margin-bottom: 17px;
    }

    .profile-info-item:last-child {
        margin-bottom: 0;
    }

    .profile-info-item span {
        display: block;
        color: #8a96a5;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .profile-info-item strong {
        color: #34465a;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .profile-form-group {
        margin-bottom: 19px;
    }

    .profile-form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #34465a;
        margin-bottom: 8px;
    }

    .profile-form-group input {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #dce3eb;
        border-radius: 9px;
        padding: 12px 14px;
        font-size: 14px;
        color: #34465a;
        outline: none;
        transition: .2s;
        background: #fff;
    }

    .profile-form-group input:focus {
        border-color: #397eae;
        box-shadow: 0 0 0 3px rgba(57, 126, 174, .1);
    }

    .profile-form-group input::placeholder {
        color: #aab4c0;
    }

    .profile-form-group small {
        display: block;
        color: #8a96a5;
        font-size: 11px;
        margin-top: 7px;
    }

    .profile-divider {
        border: 0;
        border-top: 1px solid #edf0f4;
        margin: 25px 0;
    }

    .profile-password-heading {
        margin-bottom: 20px;
    }

    .profile-password-heading h3 {
        font-size: 15px;
        color: #34465a;
        margin: 0 0 5px;
    }

    .profile-password-heading p {
        font-size: 12px;
        color: #8995a4;
        margin: 0;
    }

    .profile-save-button {
        border: 0;
        border-radius: 9px;
        background: #24527a;
        color: #fff;
        padding: 12px 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .profile-save-button:hover {
        background: #193e60;
        transform: translateY(-1px);
    }

    .profile-note {
        background: #f3f7fb;
        border: 1px solid #e3edf6;
        border-radius: 12px;
        padding: 16px;
        margin-top: 20px;
    }

    .profile-note strong {
        display: block;
        color: #24527a;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .profile-note p {
        color: #718096;
        font-size: 12px;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 900px) {
        .profile-wrapper {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .profile-card {
            padding: 19px;
        }

        .profile-save-button {
            width: 100%;
        }
    }
</style>

@php
    $role = str_replace('_', ' ', $user->role?->nama_role ?? 'Pengguna');
@endphp

<div class="profile-wrapper">

    {{-- INFORMASI AKUN --}}
    <section class="profile-card">

        <div class="profile-summary">

            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <h3>{{ $user->name }}</h3>

            <p>{{ $user->email }}</p>

            <span class="profile-role">
                {{ $role }}
            </span>

        </div>

        <div class="profile-info">

            <div class="profile-info-item">
                <span>Nama Lengkap</span>
                <strong>{{ $user->name }}</strong>
            </div>

            <div class="profile-info-item">
                <span>Email Akun</span>
                <strong>{{ $user->email }}</strong>
            </div>

            <div class="profile-info-item">
                <span>Peran Akun</span>
                <strong>{{ ucfirst($role) }}</strong>
            </div>

            @if ($user->instansi)
                <div class="profile-info-item">
                    <span>Instansi</span>
                    <strong>{{ $user->instansi->nama_instansi }}</strong>
                </div>
            @endif

        </div>

        <div class="profile-note">
            <strong>Informasi akun</strong>

            <p>
                Halaman ini digunakan untuk memperbarui informasi akun
                yang sedang Anda gunakan. Perubahan tidak memengaruhi
                akun pengguna lainnya.
            </p>
        </div>

    </section>

    {{-- FORM EDIT PROFIL --}}
    <section class="profile-card">

        <div class="profile-card-heading">
            <h2>Edit Informasi Akun</h2>
            <p>Perbarui nama dan email akun Anda.</p>
        </div>

        <form
            action="{{ auth()->user()->role?->nama_role === 'super_admin'
                ? route('super-admin.profil.update')
                : route('admin.profil.update') }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="profile-form-group">
                <label for="name">Nama Lengkap</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            <div class="profile-form-group">
                <label for="email">Alamat Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    placeholder="Masukkan alamat email"
                    required
                >
            </div>

            <hr class="profile-divider">

            <div class="profile-password-heading">
                <h3>Keamanan Password</h3>
                <p>
                    Kosongkan bagian password jika tidak ingin menggantinya.
                </p>
            </div>

            <div class="profile-form-group">
                <label for="current_password">Password Lama</label>

                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    placeholder="Masukkan password lama"
                    autocomplete="current-password"
                >
            </div>

            <div class="profile-form-group">
                <label for="password">Password Baru</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password baru"
                    autocomplete="new-password"
                >

                <small>Minimal 8 karakter.</small>
            </div>

            <div class="profile-form-group">
                <label for="password_confirmation">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password baru"
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="profile-save-button">
                Simpan Perubahan
            </button>

        </form>

    </section>

</div>

@endsection

@push('scripts')
@if (session('profile_updated'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Profil Berhasil Diperbarui',
        text: 'Informasi akun Anda berhasil disimpan.',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#24527a'
    });
</script>
@endif
@endpush
