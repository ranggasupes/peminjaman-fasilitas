
@extends('layouts.app')

@section('title', 'Dashboard Super Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan informasi sistem peminjaman fasilitas publik.')

@section('content')

    {{-- Statistik Dashboard --}}
    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">▤</div>
            <div>
                <div class="stat-label">Total Instansi</div>
                <div class="stat-value">
                    {{ \App\Models\Instansi::count() }}
                </div>
                <div class="stat-note">Instansi terdaftar</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⌂</div>
            <div>
                <div class="stat-label">Total Fasilitas</div>
                <div class="stat-value">
                    {{ \App\Models\Fasilitas::count() }}
                </div>
                <div class="stat-note">Fasilitas terdaftar</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">♙</div>
            <div>
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-value">
                    {{ \App\Models\User::count() }}
                </div>
                <div class="stat-note">Seluruh akun pengguna</div>
            </div>
        </div>
    </section>

    {{-- Ringkasan Dashboard --}}
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Selamat Datang, Super Admin!</h2>
                <p>
                    Kelola dan pantau sistem peminjaman fasilitas publik
                    melalui dashboard ini.
                </p>
            </div>
        </div>

        <p>
            Dashboard ini menyajikan ringkasan data yang terdaftar dalam
            sistem. Gunakan menu navigasi di sebelah kiri untuk mengelola
            data instansi dan fasilitas sesuai kebutuhan.
        </p>
    </section>

    {{-- Informasi Sistem --}}
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Informasi Sistem</h2>
                <p>Informasi singkat mengenai pengelolaan aplikasi.</p>
            </div>
        </div>

        <div class="action-group">
            <div>
                <h3>Data Instansi</h3>
                <p>
                    Mengelola informasi instansi yang menyediakan
                    fasilitas publik.
                </p>
            </div>

            <a href="{{ route('instansi.index') }}" class="btn btn-secondary">
                Kelola Instansi →
            </a>
        </div>

        <div class="action-group">
            <div>
                <h3>Data Fasilitas</h3>
                <p>
                    Mengelola informasi fasilitas, tarif, lokasi,
                    jadwal operasional, dan status fasilitas.
                </p>
            </div>

            <a href="{{ route('fasilitas.index') }}" class="btn btn-secondary">
                Kelola Fasilitas →
            </a>
        </div>
    </section>

@endsection
