
@extends('layouts.app')

@section('title', 'Edit Fasilitas')
@section('page-title', 'Edit Fasilitas')
@section('page-description', 'Perbarui informasi fasilitas yang telah terdaftar.')

@section('content')

@php
    $isAdmin = auth()->user()->role?->nama_role === 'admin_fasilitas';

    $routeIndex = $isAdmin ? 'admin.fasilitas.index' : 'fasilitas.index';
    $routeUpdate = $isAdmin ? 'admin.fasilitas.update' : 'fasilitas.update';
@endphp

<section class="panel fasilitas-form-panel">

    <div class="panel-header">
        <div>
            <h2>Edit Fasilitas</h2>
            <p>Perbarui data {{ $fasilitas->nama_fasilitas }}.</p>
        </div>

        <a href="{{ route($routeIndex) }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <form
        action="{{ route($routeUpdate, ['fasilitas' => $fasilitas->id]) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('fasilitas.form', [
            'fasilitas' => $fasilitas,
            'isAdmin' => $isAdmin
        ])

        <div class="fasilitas-form-actions">

            <a href="{{ route($routeIndex) }}" class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

        </div>

    </form>

</section>

@endsection
