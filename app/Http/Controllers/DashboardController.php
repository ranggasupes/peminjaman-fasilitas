<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        return view('dashboard.super-admin');
    }

    public function admin()
    {
        $user = Auth::user();

        // Pastikan akun admin memiliki instansi
        abort_unless($user->instansi_id, 403, 'Akun admin belum terhubung dengan instansi.');

        $instansiId = $user->instansi_id;

        // Mengambil fasilitas milik instansi admin
        $totalFasilitas = Fasilitas::where('instansi_id', $instansiId)
            ->count();

        $fasilitasAktif = Fasilitas::where('instansi_id', $instansiId)
            ->where('aktif', true)
            ->count();

        // Mengambil pengajuan dari fasilitas milik instansi admin
        $pengajuanMenunggu = Peminjaman::whereHas('fasilitas', function ($query) use ($instansiId) {
            $query->where('instansi_id', $instansiId);
        })
            ->whereIn('status', [
                'diajukan',
                'menunggu_verifikasi_pembayaran',
            ])
            ->count();

        $totalPeminjamanDisetujui = Peminjaman::whereHas('fasilitas', function ($query) use ($instansiId) {
            $query->where('instansi_id', $instansiId);
        })
            ->whereIn('status', [
                'disetujui',
                'menunggu_pembayaran',
                'dikonfirmasi',
            ])
            ->count();

        // Daftar fasilitas milik instansi admin
        $fasilitas = Fasilitas::with('instansi')
            ->where('instansi_id', $instansiId)
            ->latest()
            ->take(5)
            ->get();

        // Pengajuan terbaru hanya dari fasilitas instansi admin
        $pengajuanTerbaru = Peminjaman::with(['fasilitas', 'user'])
            ->whereHas('fasilitas', function ($query) use ($instansiId) {
                $query->where('instansi_id', $instansiId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'user',
            'totalFasilitas',
            'fasilitasAktif',
            'pengajuanMenunggu',
            'totalPeminjamanDisetujui',
            'fasilitas',
            'pengajuanTerbaru'
        ));
    }

    public function peminjam()
    {
        $userId = Auth::id();

        $totalFasilitas = Fasilitas::where('aktif', true)->count();

        $fasilitas = Fasilitas::with('instansi')
            ->where('aktif', true)
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $peminjaman = Peminjaman::with('fasilitas')
            ->where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        $jumlahPengajuan = Peminjaman::where('user_id', $userId)
            ->whereIn('status', [
                'diajukan',
                'perlu_perbaikan',
                'disetujui',
                'menunggu_pembayaran',
                'menunggu_verifikasi_pembayaran',
                'dikonfirmasi',
            ])
            ->count();

        return view('dashboard.peminjam', compact(
            'fasilitas',
            'totalFasilitas',
            'peminjaman',
            'jumlahPengajuan'
        ));
    }
}
