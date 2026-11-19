<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PEMBANTU HAK AKSES
    |--------------------------------------------------------------------------
    */

    private function isAdminFasilitas(): bool
    {
        return Auth::user()->role?->nama_role === 'admin_fasilitas';
    }

    private function adminInstansiId()
    {
        $user = Auth::user();

        abort_unless(
            $user->instansi_id,
            403,
            'Akun admin belum terhubung dengan instansi.'
        );

        return $user->instansi_id;
    }

    private function redirectIndex()
    {
        return redirect()->route(
            $this->isAdminFasilitas()
                ? 'admin.fasilitas.index'
                : 'fasilitas.index'
        );
    }

    private function pastikanHakAkses(Fasilitas $fasilitas): void
    {
        if ($this->isAdminFasilitas()) {
            abort_unless(
                $fasilitas->instansi_id == $this->adminInstansiId(),
                403,
                'Anda tidak memiliki akses ke fasilitas ini.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $query = Fasilitas::with('instansi')->latest();

        if ($this->isAdminFasilitas()) {
            $query->where(
                'instansi_id',
                $this->adminInstansiId()
            );
        }

        $fasilitas = $query->paginate(10);

        return view('fasilitas.index', compact('fasilitas'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $isAdmin = $this->isAdminFasilitas();

        if ($isAdmin) {
            $instansi = Instansi::where(
                'id',
                $this->adminInstansiId()
            )->get();
        } else {
            $instansi = Instansi::orderBy('nama_instansi')->get();
        }

        return view('fasilitas.create', compact(
            'instansi',
            'isAdmin'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $isAdmin = $this->isAdminFasilitas();

        $rules = [
            'nama_fasilitas' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'persyaratan' => ['nullable', 'string'],
            'tarif' => ['required', 'numeric', 'min:0'],
            'jadwal_operasional' => ['nullable', 'string'],
            'template_surat' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'aktif' => ['required', 'boolean'],
        ];

        if (!$isAdmin) {
            $rules['instansi_id'] = [
                'required',
                'exists:instansi,id',
            ];
        }

        $data = $request->validate($rules);

        // Admin tidak boleh menentukan instansi sendiri
        if ($isAdmin) {
            $data['instansi_id'] = $this->adminInstansiId();
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('fasilitas', 'public');
        }

        if ($request->hasFile('template_surat')) {
            $data['template_surat'] = $request->file('template_surat')
                ->store('template-surat', 'public');
        }

        Fasilitas::create($data);

        return $this->redirectIndex()
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Fasilitas $fasilitas)
    {
        $this->pastikanHakAkses($fasilitas);

        $isAdmin = $this->isAdminFasilitas();

        if ($isAdmin) {
            $instansi = Instansi::where(
                'id',
                $this->adminInstansiId()
            )->get();
        } else {
            $instansi = Instansi::orderBy('nama_instansi')->get();
        }

        return view('fasilitas.edit', compact(
            'fasilitas',
            'instansi',
            'isAdmin'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $this->pastikanHakAkses($fasilitas);

        $isAdmin = $this->isAdminFasilitas();

        $rules = [
            'nama_fasilitas' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'persyaratan' => ['nullable', 'string'],
            'tarif' => ['required', 'numeric', 'min:0'],
            'jadwal_operasional' => ['nullable', 'string'],
            'template_surat' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'aktif' => ['required', 'boolean'],
        ];

        if (!$isAdmin) {
            $rules['instansi_id'] = [
                'required',
                'exists:instansi,id',
            ];
        }

        $data = $request->validate($rules);

        // Instansi fasilitas tidak bisa diganti oleh admin
        if ($isAdmin) {
            unset($data['instansi_id']);
        }

        if ($request->hasFile('foto')) {
            if ($fasilitas->foto) {
                Storage::disk('public')->delete($fasilitas->foto);
            }

            $data['foto'] = $request->file('foto')
                ->store('fasilitas', 'public');
        }

        if ($request->hasFile('template_surat')) {
            if ($fasilitas->template_surat) {
                Storage::disk('public')->delete($fasilitas->template_surat);
            }

            $data['template_surat'] = $request->file('template_surat')
                ->store('template-surat', 'public');
        }

        $fasilitas->update($data);

        return $this->redirectIndex()
            ->with('success', 'Data fasilitas berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Fasilitas $fasilitas)
    {
        $this->pastikanHakAkses($fasilitas);

        if ($fasilitas->peminjaman()->exists()) {
            return $this->redirectIndex()
                ->with(
                    'error',
                    'Fasilitas tidak dapat dihapus karena sudah memiliki data peminjaman.'
                );
        }

        if ($fasilitas->foto) {
            Storage::disk('public')->delete($fasilitas->foto);
        }

        if ($fasilitas->template_surat) {
            Storage::disk('public')->delete($fasilitas->template_surat);
        }

        $fasilitas->delete();

        return $this->redirectIndex()
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
