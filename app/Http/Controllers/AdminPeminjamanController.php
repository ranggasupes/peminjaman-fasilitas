<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPeminjamanController extends Controller
{
    /**
     * Memastikan pengajuan berasal dari instansi admin yang login.
     */
    private function getPengajuanMilikInstansi(Peminjaman $peminjaman): Peminjaman
    {
        $instansiId = Auth::user()->instansi_id;

        abort_unless(
            $instansiId,
            403,
            'Akun admin belum terhubung dengan instansi.'
        );

        abort_unless(
            $peminjaman->fasilitas()
                ->where('instansi_id', $instansiId)
                ->exists(),
            403,
            'Kamu tidak memiliki akses ke pengajuan ini.'
        );

        return $peminjaman;
    }

    /**
     * Daftar pengajuan peminjaman untuk instansi admin.
     */
    public function index()
    {
        $instansiId = Auth::user()->instansi_id;

        abort_unless(
            $instansiId,
            403,
            'Akun admin belum terhubung dengan instansi.'
        );

        $peminjaman = Peminjaman::with([
            'user',
            'fasilitas',
            'pembayaran',
        ])
            ->whereHas('fasilitas', function ($query) use ($instansiId) {
                $query->where('instansi_id', $instansiId);
            })
            ->latest()
            ->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Detail pengajuan.
     */
    public function show(Peminjaman $peminjaman)
    {
        $this->getPengajuanMilikInstansi($peminjaman);

        $peminjaman->load([
            'user',
            'fasilitas.instansi',
            'dokumen',
            'pembayaran',
        ]);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Menyetujui pengajuan dan membuat tagihan pembayaran.
     */
    public function approve(Peminjaman $peminjaman)
    {
        $this->getPengajuanMilikInstansi($peminjaman);

        DB::transaction(function () use ($peminjaman) {
            $data = Peminjaman::whereKey($peminjaman->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $data->status === 'diajukan',
                422,
                'Pengajuan ini sudah diproses.'
            );

            $data->pembayaran()->updateOrCreate(
                ['peminjaman_id' => $data->id],
                [
                    'jumlah_bayar' => $data->total_biaya,
                    'status' => 'belum_bayar',
                    'bukti_pembayaran' => null,
                    'catatan_admin' => null,
                    'tanggal_bayar' => null,
                ]
            );

            $data->update([
                'status' => 'menunggu_pembayaran',
                'catatan_admin' => null,
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.show', $peminjaman->id)
            ->with(
                'success',
                'Pengajuan disetujui. Peminjam sekarang dapat melakukan pembayaran.'
            );
    }

    /**
     * Menolak pengajuan.
     */
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $this->getPengajuanMilikInstansi($peminjaman);

        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:2000'],
        ], [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi.',
            'catatan_admin.max' => 'Alasan penolakan maksimal 2000 karakter.',
        ]);

        DB::transaction(function () use ($peminjaman, $validated) {
            $data = Peminjaman::whereKey($peminjaman->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $data->status === 'diajukan',
                422,
                'Pengajuan ini sudah diproses.'
            );

            $data->update([
                'status' => 'ditolak',
                'catatan_admin' => $validated['catatan_admin'],
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.show', $peminjaman->id)
            ->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }

    /**
     * Meminta peminjam memperbaiki pengajuan.
     */
    public function requestRevision(Request $request, Peminjaman $peminjaman)
    {
        $this->getPengajuanMilikInstansi($peminjaman);

        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:2000'],
        ], [
            'catatan_admin.required' => 'Catatan perbaikan wajib diisi.',
            'catatan_admin.max' => 'Catatan maksimal 2000 karakter.',
        ]);

        DB::transaction(function () use ($peminjaman, $validated) {
            $data = Peminjaman::whereKey($peminjaman->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $data->status === 'diajukan',
                422,
                'Pengajuan ini sudah diproses.'
            );

            $data->update([
                'status' => 'perlu_perbaikan',
                'catatan_admin' => $validated['catatan_admin'],
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.show', $peminjaman->id)
            ->with(
                'success',
                'Pengajuan dikembalikan untuk diperbaiki.'
            );
    }

    /**
     * Memverifikasi bukti pembayaran.
     */
    public function verifyPayment(Peminjaman $peminjaman)
    {
        $this->getPengajuanMilikInstansi($peminjaman);

        DB::transaction(function () use ($peminjaman) {
            $data = Peminjaman::whereKey($peminjaman->id)
                ->lockForUpdate()
                ->firstOrFail();

            $pembayaran = $data->pembayaran()
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $data->status === 'menunggu_verifikasi_pembayaran'
                && $pembayaran->status === 'menunggu_verifikasi',
                422,
                'Pembayaran belum siap diverifikasi.'
            );

            $pembayaran->update([
                'status' => 'terverifikasi',
                'catatan_admin' => null,
            ]);

            $data->update([
                'status' => 'dikonfirmasi',
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.show', $peminjaman->id)
            ->with(
                'success',
                'Pembayaran berhasil diverifikasi. Peminjaman telah dikonfirmasi.'
            );
    }

    /**
     * Menolak bukti pembayaran.
     */
    public function rejectPayment(Request $request, Peminjaman $peminjaman)
    {
        $this->getPengajuanMilikInstansi($peminjaman);

        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:2000'],
        ], [
            'catatan_admin.required' => 'Alasan penolakan pembayaran wajib diisi.',
            'catatan_admin.max' => 'Catatan maksimal 2000 karakter.',
        ]);

        DB::transaction(function () use ($peminjaman, $validated) {
            $data = Peminjaman::whereKey($peminjaman->id)
                ->lockForUpdate()
                ->firstOrFail();

            $pembayaran = $data->pembayaran()
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $data->status === 'menunggu_verifikasi_pembayaran'
                && $pembayaran->status === 'menunggu_verifikasi',
                422,
                'Pembayaran ini sudah diproses.'
            );

            $pembayaran->update([
                'status' => 'ditolak',
                'catatan_admin' => $validated['catatan_admin'],
            ]);

            $data->update([
                'status' => 'menunggu_pembayaran',
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.show', $peminjaman->id)
            ->with(
                'success',
                'Bukti pembayaran ditolak. Peminjam dapat mengunggah bukti pembayaran ulang.'
            );
    }
}
