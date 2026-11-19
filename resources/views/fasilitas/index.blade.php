
@extends('layouts.app')

@section('title', 'Data Fasilitas')
@section('page-title', auth()->user()->role?->nama_role === 'admin_fasilitas' ? 'Kelola Fasilitas' : 'Data Fasilitas')
@section('page-description', auth()->user()->role?->nama_role === 'admin_fasilitas'
    ? 'Kelola fasilitas yang berada di bawah tanggung jawab instansi Anda.'
    : 'Kelola fasilitas publik yang tersedia di setiap instansi.')

@section('content')

@php
    $isAdmin = auth()->user()->role?->nama_role === 'admin_fasilitas';

    $routeIndex = $isAdmin ? 'admin.fasilitas.index' : 'fasilitas.index';
    $routeCreate = $isAdmin ? 'admin.fasilitas.create' : 'fasilitas.create';
    $routeEdit = $isAdmin ? 'admin.fasilitas.edit' : 'fasilitas.edit';
    $routeDestroy = $isAdmin ? 'admin.fasilitas.destroy' : 'fasilitas.destroy';
@endphp

<section class="panel fasilitas-admin-panel">

    <div class="panel-header">
        <div>
            <h2>{{ $isAdmin ? 'Fasilitas Instansi Saya' : 'Daftar Fasilitas' }}</h2>

            <p>
                {{ $isAdmin
                    ? 'Daftar fasilitas yang dapat Anda kelola.'
                    : 'Tambah, lihat, ubah, dan hapus data fasilitas.' }}
            </p>
        </div>

        <a href="{{ route($routeCreate) }}" class="btn btn-primary">
            + Tambah Fasilitas
        </a>
    </div>

    @if (session('success'))
        <div class="fasilitas-alert fasilitas-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fasilitas-alert fasilitas-alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="fasilitas-alert fasilitas-alert-error">
            Data tidak berhasil diproses. Periksa kembali formulir.
        </div>
    @endif

    <div class="fasilitas-table-wrap">

        <table class="fasilitas-table">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Foto</th>
                    <th>Nama Fasilitas</th>

                    @if (!$isAdmin)
                        <th>Instansi</th>
                    @endif

                    <th>Tarif</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($fasilitas as $item)

                    <tr>

                        <td>
                            {{ $fasilitas->firstItem() + $loop->index }}
                        </td>

                        <td>
                            @if ($item->foto)
                                <img
                                    src="{{ asset('storage/' . $item->foto) }}"
                                    alt="{{ $item->nama_fasilitas }}"
                                    class="fasilitas-table-photo">
                            @else
                                <div class="fasilitas-no-photo">
                                    Tidak ada foto
                                </div>
                            @endif
                        </td>

                        <td>
                            <div class="fasilitas-table-name">
                                {{ $item->nama_fasilitas }}
                            </div>

                            <small>
                                {{ $item->lokasi ?: 'Lokasi belum diisi' }}
                            </small>
                        </td>

                        @if (!$isAdmin)
                            <td>
                                {{ $item->instansi->nama_instansi ?? '-' }}
                            </td>
                        @endif

                        <td>
                            Rp {{ number_format((float) $item->tarif, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="fasilitas-status {{ $item->aktif ? 'is-active' : 'is-inactive' }}">
                                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>

                        <td>
                            <div class="fasilitas-action-buttons">

                                <a
                                    href="{{ route($routeEdit, ['fasilitas' => $item->id]) }}"
                                    class="btn btn-secondary fasilitas-edit-btn">
                                    Edit
                                </a>

                                <form
                                    action="{{ route($routeDestroy, ['fasilitas' => $item->id]) }}"
                                    method="POST"
                                    class="form-hapus-fasilitas"
                                    data-nama="{{ $item->nama_fasilitas }}">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="fasilitas-delete-btn">
                                        Hapus
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isAdmin ? 6 : 7 }}" class="fasilitas-empty-row">
                            Belum ada data fasilitas.

                            <a href="{{ route($routeCreate) }}">
                                Tambah fasilitas sekarang
                            </a>.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="fasilitas-pagination">
        {{ $fasilitas->links() }}
    </div>

</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const formsHapus = document.querySelectorAll('.form-hapus-fasilitas');

    formsHapus.forEach(function (form) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            const namaFasilitas = form.dataset.nama || 'fasilitas ini';

            Swal.fire({
                title: 'Hapus Fasilitas?',
                html: `
                    <p class="mb-2">
                        Apakah kamu yakin ingin menghapus
                        <strong>${escapeHtml(namaFasilitas)}</strong>?
                    </p>
                    <p class="text-muted small mb-0">
                        Data fasilitas yang dihapus tidak dapat dikembalikan.
                    </p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'rounded-3 px-4',
                    cancelButton: 'rounded-3 px-4'
                }
            }).then(function (result) {

                if (result.isConfirmed) {
                    HTMLFormElement.prototype.submit.call(form);
                }

            });

        });

    });

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[character];
        });
    }

});
</script>
@endpush
