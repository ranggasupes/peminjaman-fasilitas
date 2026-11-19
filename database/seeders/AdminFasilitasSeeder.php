<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Instansi;

class AdminFasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('nama_role', 'admin_fasilitas')
            ->firstOrFail();

        $instansis = Instansi::all();

        foreach ($instansis as $instansi) {

            $slug = Str::slug($instansi->nama_instansi);

            $email = 'admin.' . $slug . '@peminjaman.com';

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin ' . $instansi->nama_instansi,
                    'password' => Hash::make('admin12345'),
                    'role_id' => $role->id,
                    'instansi_id' => $instansi->id,
                ]
            );

            $this->command->info(
                'Akun berhasil dibuat: ' . $email
            );
        }

        $this->command->info('Semua akun Admin Fasilitas selesai dibuat!');
    }
}
