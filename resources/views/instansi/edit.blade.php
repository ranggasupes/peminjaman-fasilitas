
@extends('layouts.app')

@section('title', 'Edit Instansi')
@section('page-title', 'Edit Instansi')
@section('page-description', 'Perbarui informasi instansi yang telah terdaftar.')

@section('content')
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Perbarui Informasi Instansi</h2>
                <p>Perubahan akan disimpan ke database setelah dikonfirmasi.</p>
            </div>
        </div>

        <form action="{{ route('instansi.update', $instansi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="nama_instansi">Nama Instansi *</label>
                    <input
                        class="form-control"
                        type="text"
                        id="nama_instansi"
                        name="nama_instansi"
                        value="{{ old('nama_instansi', $instansi->nama_instansi) }}"
                        required
                    >
                </div>

                <div class="form-group full-width">
                    <label for="alamat">Alamat Instansi</label>
                    <textarea
                        class="form-control"
                        id="alamat"
                        name="alamat"
                    >{{ old('alamat', $instansi->alamat) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        class="form-control"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $instansi->email) }}"
                    >
                </div>

                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon</label>
                    <input
                        class="form-control"
                        type="text"
                        id="no_telepon"
                        name="no_telepon"
                        value="{{ old('no_telepon', $instansi->no_telepon) }}"
                    >
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('instansi.index') }}" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
@endsection
