
@extends('layouts.peminjam')

@section('title', 'Profil Saya | Fasilitasku')

@section('content')

<section class="profile-page">

    <div class="profile-heading">
        <div>
            <span class="profile-eyebrow">PENGATURAN AKUN</span>
            <h1>Profil Saya</h1>
            <p>Kelola informasi akun yang kamu gunakan untuk layanan Fasilitasku.</p>
        </div>
    </div>

    <div class="profile-card">

        <div class="profile-card-header">
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div>
                <h2>{{ auth()->user()->name }}</h2>
                <p>{{ auth()->user()->email }}</p>
                <span class="profile-status">Akun Peminjam</span>
            </div>
        </div>

        <form action="{{ route('peminjam.profil.update') }}"
              method="POST"
              class="profile-form">

            @csrf
            @method('PUT')

            <div class="profile-section-title">
                <h3>Informasi Pribadi</h3>
                <p>Perbarui nama dan alamat email akunmu.</p>
            </div>

            <div class="profile-field">
                <label for="name">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >

                @error('name')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-field">
                <label for="email">Alamat Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', auth()->user()->email) }}"
                    placeholder="contoh@email.com"
                    required
                >

                @error('email')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-divider"></div>

            <div class="profile-section-title">
                <h3>Ubah Password</h3>
                <p>Kosongkan bagian ini jika tidak ingin mengganti password.</p>
            </div>

            <div class="profile-field">
                <label for="current_password">Password Saat Ini</label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    placeholder="Masukkan password saat ini"
                    autocomplete="current-password"
                >

                @error('current_password')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-field">
                <label for="password">Password Baru</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                >

                @error('password')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-field">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password baru"
                    autocomplete="new-password"
                >
            </div>

            <div class="profile-actions">
                <a href="{{ route('dashboard.peminjam') }}"
                   class="profile-cancel">
                    Kembali
                </a>

                <button type="submit" class="profile-submit">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</section>

@endsection

@push('styles')
<style>
.profile-page {
    max-width: 900px;
    margin: 35px auto 65px;
}

.profile-heading {
    margin-bottom: 25px;
}

.profile-eyebrow {
    color: #2874a6;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.5px;
}

.profile-heading h1 {
    margin: 8px 0;
    color: #1c2b3a;
    font-size: 30px;
    font-weight: 800;
}

.profile-heading p {
    color: #718096;
    margin: 0;
    font-size: 14px;
}

.profile-card {
    background: #fff;
    border: 1px solid #e8edf2;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(25, 45, 70, .05);
}

.profile-card-header {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 28px 32px;
    background: #f8fafc;
    border-bottom: 1px solid #edf1f5;
}

.profile-avatar {
    width: 65px;
    height: 65px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #24527a;
    color: white;
    font-size: 27px;
    font-weight: 800;
}

.profile-card-header h2 {
    margin: 0 0 5px;
    color: #1c2b3a;
    font-size: 19px;
    font-weight: 700;
}

.profile-card-header p {
    margin: 0 0 8px;
    color: #718096;
    font-size: 13px;
}

.profile-status {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    background: #e7f3ff;
    color: #24527a;
    font-size: 11px;
    font-weight: 700;
}

.profile-form {
    padding: 30px 32px;
}

.profile-section-title {
    margin-bottom: 20px;
}

.profile-section-title h3 {
    margin: 0 0 5px;
    color: #243447;
    font-size: 17px;
    font-weight: 700;
}

.profile-section-title p {
    margin: 0;
    color: #8794a3;
    font-size: 13px;
}

.profile-field {
    margin-bottom: 19px;
}

.profile-field label {
    display: block;
    margin-bottom: 8px;
    color: #344054;
    font-size: 13px;
    font-weight: 600;
}

.profile-field input {
    width: 100%;
    min-height: 46px;
    padding: 11px 14px;
    border: 1px solid #dce3eb;
    border-radius: 9px;
    outline: none;
    background: #fff;
    color: #263445;
    font-family: inherit;
    font-size: 13px;
    transition: .2s;
}

.profile-field input:focus {
    border-color: #3979ad;
    box-shadow: 0 0 0 3px rgba(57, 121, 173, .10);
}

.profile-field input::placeholder {
    color: #aab4c0;
}

.profile-error {
    display: block;
    margin-top: 6px;
    color: #dc3545;
    font-size: 12px;
}

.profile-divider {
    height: 1px;
    background: #edf1f5;
    margin: 28px 0;
}

.profile-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 30px;
    padding-top: 22px;
    border-top: 1px solid #edf1f5;
}

.profile-cancel,
.profile-submit {
    min-height: 43px;
    padding: 11px 20px;
    border-radius: 9px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: .2s;
}

.profile-cancel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dce3eb;
    color: #536273;
    background: white;
}

.profile-cancel:hover {
    background: #f5f7fa;
}

.profile-submit {
    border: none;
    background: #24527a;
    color: white;
}

.profile-submit:hover {
    background: #193e60;
}

@media (max-width: 600px) {
    .profile-page {
        margin: 22px 0 40px;
    }

    .profile-card-header,
    .profile-form {
        padding: 22px 18px;
    }

    .profile-actions {
        flex-direction: column-reverse;
    }

    .profile-cancel,
    .profile-submit {
        width: 100%;
        text-align: center;
    }
}
</style>
@endpush
