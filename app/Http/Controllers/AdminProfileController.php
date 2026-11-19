<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    /**
     * Menentukan route profil berdasarkan role pengguna.
     */
    private function routeProfil(): string
    {
        return match (Auth::user()->role?->nama_role) {
            'super_admin' => 'super-admin.profil.edit',
            'admin_fasilitas' => 'admin.profil.edit',
            default => abort(403, 'Akses tidak diizinkan.'),
        };
    }

    /**
     * Menampilkan halaman profil.
     */
    public function edit()
    {
        $user = Auth::user();
        $user->load('role', 'instansi');

        return view('admin.profil.edit', compact('user'));
    }

    /**
     * Memperbarui profil pengguna yang sedang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'current_password' => [
                'nullable',
                'required_with:password',
                'current_password',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'current_password.required_with' => 'Password lama wajib diisi untuk mengganti password.',
            'current_password.current_password' => 'Password lama yang dimasukkan tidak sesuai.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Password hanya diubah jika password baru diisi.
        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route($this->routeProfil())
            ->with('profile_updated', true);
    }
}
