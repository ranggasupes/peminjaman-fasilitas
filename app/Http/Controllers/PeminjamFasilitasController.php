<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;

class PeminjamFasilitasController extends Controller
{
    public function show(Fasilitas $fasilitas)
    {
        abort_unless($fasilitas->aktif, 404);

        $fasilitas->load('instansi');

        return view('peminjam.fasilitas.show', compact('fasilitas'));
    }
}
