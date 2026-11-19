
@extends('layouts.app')

@section('title', 'Tambah Fasilitas')
@section('page-title', 'Tambah Fasilitas')
@section('page-description', 'Masukkan informasi fasilitas yang akan didaftarkan.')

@section('content')

@php
    $isAdmin = auth()->user()->role?->nama_role === 'admin_fasilitas';

    $routeIndex = $isAdmin ? 'admin.fasilitas.index' : 'fasilitas.index';
    $routeStore = $isAdmin ? 'admin.fasilitas.store' : 'fasilitas.store';
@endphp

<section class="panel fasilitas-form-panel">

    <div class="panel-header">
        <div>
            <h2>Formulir Fasilitas</h2>
            <p>Lengkapi informasi fasilitas di bawah ini.</p>
        </div>

        <a href="{{ route($routeIndex) }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <form
        action="{{ route($routeStore) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        @include('fasilitas.form', [
            'fasilitas' => null,
            'isAdmin' => $isAdmin
        ])

        <div class="fasilitas-form-actions">
            <a href="{{ route($routeIndex) }}" class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-primary">
                Simpan Fasilitas
            </button>
        </div>

    </form>

</section>

@endsection
