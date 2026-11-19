<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('fasilitas.instansi')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjam.peminjaman.index', compact('peminjaman'));
    }

    public function riwayat()
    {
        $peminjaman = Peminjaman::with('fasilitas.instansi')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjam.peminjaman.riwayat', compact('peminjaman'));
    }

    public function create(Fasilitas $fasilitas)
    {
        abort_unless($fasilitas->aktif, 404);

        return view('peminjam.peminjaman.create', compact('fasilitas'));
    }


public function store(Request $request, Fasilitas $fasilitas)
{
    abort_unless($fasilitas->aktif, 404);

    $data = $request->validate([
        'waktu_mulai' => ['required', 'date', 'after:now'],
        'waktu_selesai' => ['required', 'date', 'after:waktu_mulai'],
        'catatan_peminjam' => ['nullable', 'string', 'max:2000'],
    ], [
        'waktu_mulai.required' => 'Tanggal dan waktu mulai wajib diisi.',
        'waktu_mulai.date' => 'Format tanggal dan waktu mulai tidak valid.',
        'waktu_mulai.after' => 'Waktu mulai harus setelah waktu sekarang.',
        'waktu_selesai.required' => 'Tanggal dan waktu selesai wajib diisi.',
        'waktu_selesai.date' => 'Format tanggal dan waktu selesai tidak valid.',
        'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
    ]);

    $peminjaman = new Peminjaman();

    $peminjaman->user_id = Auth::id();
    $peminjaman->fasilitas_id = $fasilitas->id;
    $peminjaman->waktu_mulai = $data['waktu_mulai'];
    $peminjaman->waktu_selesai = $data['waktu_selesai'];
    $peminjaman->total_biaya = $fasilitas->tarif ?? 0;
    $peminjaman->catatan_peminjam = $data['catatan_peminjam'] ?? null;
    $peminjaman->status = 'diajukan';

    $peminjaman->save();

    return redirect()
        ->route('peminjam.peminjaman.index')
        ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
}

}
