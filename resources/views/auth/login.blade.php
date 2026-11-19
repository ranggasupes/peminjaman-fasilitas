
@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="login-card">
        <div class="login-brand">
            <span class="brand-icon">F</span>
            <div>
                <strong style="display:block;font-size:18px;">FasilitasKu</strong>
                <small style="color:#78857e;">Layanan Peminjaman Fasilitas</small>
            </div>
        </div>

        <h1>Selamat datang!</h1>
        <p class="login-description">
            Masuk ke akun Anda untuk mengakses layanan peminjaman fasilitas.
        </p>

        {{-- Notifikasi registrasi berhasil --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pesan kesalahan login --}}
        @if ($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Alamat email</label>
                <input
                    class="form-control"
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nama@email.com"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Kata sandi</label>
                <input
                    class="form-control"
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan kata sandi"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button class="btn btn-primary" type="submit">
                Masuk ke akun <span>→</span>
            </button>
        </form>

        {{-- Tautan registrasi khusus peminjam --}}
        <div class="login-register-link">
            <p>Belum punya akun?</p>
            <a href="{{ route('register') }}">
                Daftar sebagai peminjam
            </a>
        </div>

        <div class="login-footer">
            &copy; {{ date('Y') }} FasilitasKu. Sistem Informasi Peminjaman Fasilitas.
        </div>
    </div>
@endsection
