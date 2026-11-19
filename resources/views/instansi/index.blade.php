
@extends('layouts.app')

@section('title', 'Data Instansi')
@section('page-title', 'Data Instansi')
@section('page-description', 'Kelola data instansi pemerintah atau lembaga penyedia fasilitas.')

@section('content')
    <section class="panel">
        <div class="panel-header">
            <div>
                <h2>Daftar Instansi</h2>
                <p>Total {{ $instansi->count() }} instansi terdaftar dalam sistem.</p>
            </div>

            <a href="{{ route('instansi.create') }}" class="btn btn-primary">
                + Tambah Instansi
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Instansi</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($instansi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->nama_instansi }}</strong></td>
                            <td>{{ $item->alamat ?: 'Belum diisi' }}</td>
                            <td>{{ $item->email ?: 'Belum diisi' }}</td>
                            <td>{{ $item->no_telepon ?: 'Belum diisi' }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('instansi.edit', $item->id) }}"
                                       class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('instansi.destroy', $item->id) }}"
                                          method="POST"
                                          class="form-hapus-instansi"
                                          data-nama="{{ $item->nama_instansi }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <strong>Belum ada data instansi</strong>
                                    Tambahkan instansi pertama untuk memulai pengelolaan fasilitas.
                                    <br><br>
                                    <a href="{{ route('instansi.create') }}"
                                       class="btn btn-primary">
                                        + Tambah Instansi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.form-hapus-instansi');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const namaInstansi = form.dataset.nama || 'instansi ini';

            Swal.fire({
                title: 'Hapus Instansi?',
                html: `
                    <p>Apakah kamu yakin ingin menghapus
                    <strong>${escapeHtml(namaInstansi)}</strong>?</p>
                    <p class="text-muted small mb-0">
                        Pastikan instansi ini memang sudah tidak digunakan.
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
