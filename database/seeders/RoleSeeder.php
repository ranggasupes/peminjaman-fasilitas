<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'peminjam',
            'admin_fasilitas',
            'super_admin',
        ];

        foreach ($roles as $namaRole) {
            Role::firstOrCreate([
                'nama_role' => $namaRole,
            ]);
        }
    }
}
