<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanAdminController extends Controller
{
    /**
     * Mengambil ID instansi milik admin yang sedang login.
     */
    private function getInstansiId(): int
    {
        $instansiId = Auth::user()->instansi_id;

        abort_unless(
            $instansiId,
            403,
            'Akun admin belum terhubung dengan instansi.'
        );

        return (int) $instansiId;
    }

    /**
     * Validasi filter laporan.
     */
    private function validasiFilter(Request $request): array
    {
        return $request->validate([
            'tanggal_awal' => [
                'nullable',
                'date',
                'before_or_equal:tanggal_akhir',
            ],
            'tanggal_akhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_awal',
            ],
            'fasilitas_id' => [
                'nullable',
                'integer',
                'exists:fasilitas,id',
            ],
        ], [
            'tanggal_awal.date' => 'Tanggal awal tidak valid.',
            'tanggal_awal.before_or_equal' => 'Tanggal awal tidak boleh melewati tanggal akhir.',
            'tanggal_akhir.date' => 'Tanggal akhir tidak valid.',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal awal.',
            'fasilitas_id.exists' => 'Fasilitas tidak ditemukan.',
        ]);
    }

    /**
     * Mengambil daftar fasilitas milik instansi admin.
     */
    private function getDaftarFasilitas(int $instansiId)
    {
        return Fasilitas::where('instansi_id', $instansiId)
            ->orderBy('nama_fasilitas')
            ->get();
    }

    /**
     * LAPORAN PEMINJAMAN
     */
    public function peminjaman(Request $request)
    {
        $instansiId = $this->getInstansiId();

        $filter = $this->validasiFilter($request);

        /*
        |--------------------------------------------------------------------------
        | QUERY DASAR
        |--------------------------------------------------------------------------
        */

        $query = Peminjaman::with([
            'user',
            'fasilitas',
            'pembayaran',
        ])
            ->whereHas('fasilitas', function ($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId);
            });

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        if (!empty($filter['tanggal_awal'])) {
            $query->whereDate(
                'waktu_mulai',
                '>=',
                $filter['tanggal_awal']
            );
        }

        if (!empty($filter['tanggal_akhir'])) {
            $query->whereDate(
                'waktu_mulai',
                '<=',
                $filter['tanggal_akhir']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER FASILITAS
        |--------------------------------------------------------------------------
        */

        if (!empty($filter['fasilitas_id'])) {
            $query->where('fasilitas_id', $filter['fasilitas_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN LAPORAN PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        $totalPeminjaman = (clone $query)->count();

        $totalBiaya = (clone $query)->sum('total_biaya');

        /*
        |--------------------------------------------------------------------------
        | REKAP STATUS PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        $rekapStatus = (clone $query)
            ->select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $statusPeminjaman = [
            'diajukan' => 'Diajukan',
            'perlu_perbaikan' => 'Perlu Perbaikan',
            'disetujui' => 'Disetujui',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi_pembayaran' => 'Menunggu Verifikasi Pembayaran',
            'dikonfirmasi' => 'Dikonfirmasi',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        $statistik = [];

        foreach ($statusPeminjaman as $status => $label) {
            $statistik[$status] = (int) ($rekapStatus[$status] ?? 0);
        }

        /*
        |--------------------------------------------------------------------------
        | DATA TABEL PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        $peminjaman = $query
            ->latest('waktu_mulai')
            ->paginate(10)
            ->withQueryString();

        $fasilitas = $this->getDaftarFasilitas($instansiId);

        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.laporan.peminjaman', compact(
            'peminjaman',
            'fasilitas',
            'filter',
            'totalPeminjaman',
            'totalBiaya',
            'statusPeminjaman',
            'statistik'
        ));
    }

    /**
     * LAPORAN PEMBAYARAN
     */
    public function pembayaran(Request $request)
    {
        $instansiId = $this->getInstansiId();

        $filter = $this->validasiFilter($request);

        /*
        |--------------------------------------------------------------------------
        | QUERY DASAR
        |--------------------------------------------------------------------------
        */

        $query = Peminjaman::with([
            'user',
            'fasilitas',
            'pembayaran',
        ])
            ->whereHas('fasilitas', function ($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId);
            })
            ->whereHas('pembayaran');

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        if (!empty($filter['tanggal_awal'])) {
            $query->whereHas('pembayaran', function ($q) use ($filter) {
                $q->whereDate(
                    'tanggal_bayar',
                    '>=',
                    $filter['tanggal_awal']
                );
            });
        }

        if (!empty($filter['tanggal_akhir'])) {
            $query->whereHas('pembayaran', function ($q) use ($filter) {
                $q->whereDate(
                    'tanggal_bayar',
                    '<=',
                    $filter['tanggal_akhir']
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER FASILITAS
        |--------------------------------------------------------------------------
        */

        if (!empty($filter['fasilitas_id'])) {
            $query->where('fasilitas_id', $filter['fasilitas_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $totalPembayaran = (clone $query)->count();

        $totalTerverifikasi = (clone $query)
            ->whereHas('pembayaran', function ($q) {
                $q->where('status', 'terverifikasi');
            })
            ->count();

        $totalMenunggu = (clone $query)
            ->whereHas('pembayaran', function ($q) {
                $q->where('status', 'menunggu_verifikasi');
            })
            ->count();

        $totalDitolak = (clone $query)
            ->whereHas('pembayaran', function ($q) {
                $q->where('status', 'ditolak');
            })
            ->count();

        $totalBelumBayar = (clone $query)
            ->whereHas('pembayaran', function ($q) {
                $q->where('status', 'belum_bayar');
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL NOMINAL PEMBAYARAN TERVERIFIKASI
        |--------------------------------------------------------------------------
        */

        $nominalTerverifikasi = (clone $query)
            ->whereHas('pembayaran', function ($q) {
                $q->where('status', 'terverifikasi');
            })
            ->join(
                'pembayaran',
                'peminjaman.id',
                '=',
                'pembayaran.peminjaman_id'
            )
            ->sum('pembayaran.jumlah_bayar');

        /*
        |--------------------------------------------------------------------------
        | DATA TABEL PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $peminjaman = $query
            ->latest('peminjaman.created_at')
            ->paginate(10)
            ->withQueryString();

        $fasilitas = $this->getDaftarFasilitas($instansiId);

        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.laporan.pembayaran', compact(
            'peminjaman',
            'fasilitas',
            'filter',
            'totalPembayaran',
            'totalTerverifikasi',
            'totalMenunggu',
            'totalDitolak',
            'totalBelumBayar',
            'nominalTerverifikasi'
        ));
    }
}
