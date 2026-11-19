
@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
    <div class="login-card">
        <div class="login-brand">
            <span class="brand-icon">F</span>
            <div>
                <strong style="display:block;font-size:18px;">FasilitasKu</strong>
                <small style="color:#78857e;">Layanan Peminjaman Fasilitas</small>
            </div>
        </div>

        <h1>Buat akun baru</h1>
        <p class="login-description">
            Daftar sebagai peminjam untuk mengakses layanan peminjaman fasilitas.
        </p>

        @if ($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama lengkap</label>
                <input
                    class="form-control"
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="email">Alamat email</label>
                <input
                    class="form-control"
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nama@email.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Kata sandi</label>
                <input
                    class="form-control"
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi kata sandi</label>
                <input
                    class="form-control"
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Masukkan ulang kata sandi"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
            </div>

            <button class="btn btn-primary" type="submit">
                Daftar sebagai peminjam <span>→</span>
            </button>
        </form>

        <div class="login-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
            <br><br>
            &copy; {{ date('Y') }} FasilitasKu. Sistem Informasi Peminjaman Fasilitas.
        </div>
    </div>
@endsection
