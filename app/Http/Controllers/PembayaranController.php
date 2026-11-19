<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Menampilkan halaman pembayaran milik peminjam.
     */
    public function show(Peminjaman $peminjaman)
    {
        abort_unless(
            $peminjaman->user_id === Auth::id(),
            403,
            'Kamu tidak memiliki akses ke pembayaran ini.'
        );

        abort_unless(
            in_array($peminjaman->status, [
                'menunggu_pembayaran',
                'menunggu_verifikasi_pembayaran',
            ]),
            403,
            'Pengajuan ini belum memasuki tahap pembayaran.'
        );

        $peminjaman->load(['fasilitas.instansi', 'pembayaran']);

        return view('peminjam.pembayaran.show', compact('peminjaman'));
    }

    /**
     * Mengunggah bukti pembayaran.
     */
    public function store(Request $request, Peminjaman $peminjaman)
    {
        abort_unless(
            $peminjaman->user_id === Auth::id(),
            403,
            'Kamu tidak memiliki akses ke pembayaran ini.'
        );

        abort_unless(
            $peminjaman->status === 'menunggu_pembayaran',
            422,
            'Pengajuan ini belum dapat menerima pembayaran.'
        );

        $validated = $request->validate([
            'bukti_pembayaran' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.mimes' => 'Bukti harus berupa JPG, JPEG, PNG, atau PDF.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 5 MB.',
        ]);

        $pembayaran = $peminjaman->pembayaran;

        abort_unless(
            $pembayaran && in_array($pembayaran->status, [
                'belum_bayar',
                'ditolak',
            ]),
            422,
            'Pembayaran ini sedang diproses atau sudah diverifikasi.'
        );

        $path = $request->file('bukti_pembayaran')
            ->store('bukti-pembayaran', 'public');

        DB::transaction(function () use ($peminjaman, $pembayaran, $path) {
            $data = $peminjaman->pembayaran()
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                in_array($data->status, ['belum_bayar', 'ditolak']),
                422,
                'Pembayaran sudah diproses.'
            );

            $data->update([
                'bukti_pembayaran' => $path,
                'status' => 'menunggu_verifikasi',
                'catatan_admin' => null,
                'tanggal_bayar' => now(),
            ]);

            $peminjaman->update([
                'status' => 'menunggu_verifikasi_pembayaran',
            ]);
        });

        return redirect()
            ->route('peminjam.pembayaran.show', $peminjaman->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.');
    }
}
