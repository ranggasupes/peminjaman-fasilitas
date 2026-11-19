
@extends('layouts.app')

@section('title', 'Laporan Pembayaran')
@section('page-title', 'Laporan Pembayaran')
@section('page-description', 'Pantau status dan rekap pembayaran peminjaman fasilitas pada instansi Anda.')

@section('content')

<style>
    .report-page { display: flex; flex-direction: column; gap: 22px; }

    .report-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .report-card, .report-panel {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(20, 40, 70, .035);
    }

    .report-card small {
        color: #718096;
        display: block;
        margin-bottom: 10px;
    }

    .report-card strong {
        font-size: 25px;
        color: #203b59;
    }

    .report-card p {
        color: #8a98a9;
        font-size: 12px;
        margin: 8px 0 0;
    }

    .report-panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .report-panel-heading h3 {
        margin: 0;
        color: #203b59;
        font-size: 17px;
    }

    .report-panel-heading p {
        margin: 5px 0 0;
        color: #8491a2;
        font-size: 13px;
    }

    .report-filter {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr)) auto;
        gap: 14px;
        align-items: end;
    }

    .report-field label {
        display: block;
        font-size: 13px;
        color: #536477;
        margin-bottom: 7px;
    }

    .report-field input, .report-field select {
        width: 100%;
        height: 43px;
        border: 1px solid #dce4ed;
        border-radius: 8px;
        padding: 0 11px;
        color: #34465a;
        background: #fff;
    }

    .report-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .report-btn {
        border: 0;
        border-radius: 8px;
        padding: 11px 16px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
    }

    .report-btn-primary {
        background: #24527a;
        color: white;
    }

    .report-btn-light {
        background: #edf2f7;
        color: #40536a;
    }

    .report-btn:hover { opacity: .88; }

    .report-status-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .report-status {
        border: 1px solid #e8edf3;
        border-radius: 10px;
        padding: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .report-status span {
        font-size: 13px;
        color: #64748b;
    }

    .report-status strong {
        color: #203b59;
        font-size: 18px;
    }

    .report-table-wrap { overflow-x: auto; }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .report-table th {
        background: #f6f8fb;
        color: #607086;
        text-align: left;
        padding: 13px 12px;
        font-size: 12px;
        font-weight: 700;
        border-bottom: 1px solid #e8edf3;
        white-space: nowrap;
    }

    .report-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #edf1f5;
        color: #40536a;
        font-size: 13px;
        vertical-align: middle;
    }

    .report-table tr:last-child td { border-bottom: 0; }

    .report-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        background: #edf2f7;
        color: #52657a;
    }

    .payment-terverifikasi {
        background: #dcfce7;
        color: #166534;
    }

    .payment-menunggu-verifikasi {
        background: #fef3c7;
        color: #92400e;
    }

    .payment-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .payment-belum-bayar {
        background: #dbeafe;
        color: #1e40af;
    }

    .report-empty {
        text-align: center;
        padding: 35px !important;
        color: #8794a5 !important;
    }

    .report-pagination { margin-top: 18px; }

    @media(max-width: 900px) {
        .report-cards { grid-template-columns: 1fr 1fr; }
        .report-filter { grid-template-columns: 1fr 1fr; }
        .report-status-grid { grid-template-columns: 1fr 1fr; }
    }

    @media(max-width: 600px) {
        .report-cards, .report-filter, .report-status-grid {
            grid-template-columns: 1fr;
        }
    }

    @media print {
        @page { size: landscape; margin: 12mm; }

        body { background: white !important; }

        .sidebar, .topbar, .page-heading, .footer,
        .report-filter-panel, .report-print-button, .report-pagination {
            display: none !important;
        }

        .app-shell, .main-area, .page-content {
            display: block !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .report-panel, .report-card {
            box-shadow: none !important;
            break-inside: avoid;
        }

        .report-table { min-width: 0 !important; }
        .report-table th, .report-table td {
            font-size: 10px !important;
        }
    }
</style>

<div class="report-page">

    {{-- RINGKASAN --}}
    <div class="report-cards">

        <div class="report-card">
            <small>Total Data Pembayaran</small>
            <strong>{{ number_format($totalPembayaran, 0, ',', '.') }}</strong>
            <p>Jumlah data pembayaran sesuai filter</p>
        </div>

        <div class="report-card">
            <small>Pembayaran Terverifikasi</small>
            <strong>{{ number_format($totalTerverifikasi, 0, ',', '.') }}</strong>
            <p>Pembayaran yang telah dikonfirmasi admin</p>
        </div>

        <div class="report-card">
            <small>Total Nominal Terverifikasi</small>
            <strong>Rp {{ number_format((float) $nominalTerverifikasi, 0, ',', '.') }}</strong>
            <p>Akumulasi pembayaran yang telah diverifikasi</p>
        </div>

    </div>

    {{-- FILTER --}}
    <section class="report-panel report-filter-panel">

        <div class="report-panel-heading">
            <div>
                <h3>Filter Laporan</h3>
                <p>Gunakan tanggal pembayaran dan fasilitas untuk menyaring data.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.laporan.pembayaran') }}">

            <div class="report-filter">

                <div class="report-field">
                    <label for="tanggal_awal">Tanggal Mulai Pembayaran</label>
                    <input type="date"
                           id="tanggal_awal"
                           name="tanggal_awal"
                           value="{{ $filter['tanggal_awal'] ?? '' }}">
                </div>

                <div class="report-field">
                    <label for="tanggal_akhir">Tanggal Akhir Pembayaran</label>
                    <input type="date"
                           id="tanggal_akhir"
                           name="tanggal_akhir"
                           value="{{ $filter['tanggal_akhir'] ?? '' }}">
                </div>

                <div class="report-field">
                    <label for="fasilitas_id">Fasilitas</label>
                    <select name="fasilitas_id" id="fasilitas_id">
                        <option value="">Semua Fasilitas</option>

                        @foreach ($fasilitas as $item)
                            <option value="{{ $item->id }}"
                                {{ (string) ($filter['fasilitas_id'] ?? '') === (string) $item->id ? 'selected' : '' }}>
                                {{ $item->nama_fasilitas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="report-actions">
                    <button type="submit" class="report-btn report-btn-primary">
                        Terapkan
                    </button>

                    <a href="{{ route('admin.laporan.pembayaran') }}"
                       class="report-btn report-btn-light">
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </section>

    {{-- REKAP STATUS --}}
    <section class="report-panel">

        <div class="report-panel-heading">
            <div>
                <h3>Rekap Status Pembayaran</h3>
                <p>Ringkasan kondisi pembayaran berdasarkan data yang tersedia.</p>
            </div>
        </div>

        <div class="report-status-grid">

            <div class="report-status">
                <span>Belum Dibayar</span>
                <strong>{{ number_format($totalBelumBayar, 0, ',', '.') }}</strong>
            </div>

            <div class="report-status">
                <span>Menunggu Verifikasi</span>
                <strong>{{ number_format($totalMenunggu, 0, ',', '.') }}</strong>
            </div>

            <div class="report-status">
                <span>Terverifikasi</span>
                <strong>{{ number_format($totalTerverifikasi, 0, ',', '.') }}</strong>
            </div>

            <div class="report-status">
                <span>Ditolak</span>
                <strong>{{ number_format($totalDitolak, 0, ',', '.') }}</strong>
            </div>

        </div>

    </section>

    {{-- TABEL PEMBAYARAN --}}
    <section class="report-panel">

        <div class="report-panel-heading">

            <div>
                <h3>Detail Data Pembayaran</h3>
                <p>Informasi pembayaran dari setiap peminjaman fasilitas.</p>
            </div>

            <button type="button"
                    class="report-btn report-btn-primary report-print-button"
                    onclick="window.print()">
                Cetak / Simpan PDF
            </button>

        </div>

        <div class="report-table-wrap">

            <table class="report-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Peminjam</th>
                        <th>Fasilitas</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($peminjaman as $index => $item)

                        @php
                            $pembayaran = $item->pembayaran;
                            $statusPembayaran = $pembayaran?->status ?? '-';
                        @endphp

                        <tr>

                            <td>{{ $peminjaman->firstItem() + $index }}</td>

                            <td>
                                <strong>{{ $item->user?->name ?? '-' }}</strong>
                                <br>
                                <small>{{ $item->user?->email ?? '' }}</small>
                            </td>

                            <td>{{ $item->fasilitas?->nama_fasilitas ?? '-' }}</td>

                            <td>
                                {{ $pembayaran?->tanggal_bayar
                                    ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td>
                                Rp {{ number_format((float) ($pembayaran?->jumlah_bayar ?? 0), 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="report-badge payment-{{ str_replace('_', '-', $statusPembayaran) }}">
                                    {{ $statusPembayaran !== '-'
                                        ? ucwords(str_replace('_', ' ', $statusPembayaran))
                                        : '-' }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="report-empty">
                                Tidak ada data pembayaran untuk filter yang dipilih.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="report-pagination">
            {{ $peminjaman->links() }}
        </div>

    </section>

</div>

@endsection
