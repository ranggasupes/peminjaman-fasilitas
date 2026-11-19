<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PeminjamSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('nama_role', 'peminjam')->firstOrFail();

        User::firstOrCreate(
            ['email' => 'peminjam@example.com'],
            [
                'name' => 'Peminjam Demo',
                'password' => Hash::make('Peminjam123!'),
                'role_id' => $role->id,
                'instansi_id' => null,
            ]
        );
    }
}