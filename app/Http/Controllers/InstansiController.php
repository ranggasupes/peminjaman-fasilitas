<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        $instansi = Instansi::latest()->get();

        return view('instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('instansi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        Instansi::create($validated);

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil ditambahkan.');
    }

    public function edit(Instansi $instansi)
    {
        return view('instansi.edit', compact('instansi'));
    }

    public function update(Request $request, Instansi $instansi)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $instansi->update($validated);

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil diperbarui.');
    }

    public function destroy(Instansi $instansi)
    {
        if ($instansi->fasilitas()->exists()) {
            return redirect()->route('instansi.index')
                ->with('error', 'Instansi tidak dapat dihapus karena masih memiliki fasilitas.');
        }

        if ($instansi->users()->exists()) {
            return redirect()->route('instansi.index')
                ->with('error', 'Instansi tidak dapat dihapus karena masih memiliki pengguna.');
        }

        $instansi->delete();

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil dihapus.');
    }
}
