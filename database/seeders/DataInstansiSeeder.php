<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataInstansiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_instansi' => 'Dinas Pemuda dan Olahraga Kota Palu',
                'alamat' => 'Kota Palu, Sulawesi Tengah',
                'email' => 'dispora@example.com',
                'no_telepon' => '0451-000001',
                'fasilitas' => [
                    [
                        'nama_fasilitas' => 'Lapangan Olahraga',
                        'deskripsi' => 'Contoh fasilitas untuk kegiatan olahraga masyarakat.',
                        'persyaratan' => 'Surat permohonan dan identitas peminjam.',
                        'tarif' => 150000,
                        'jadwal_operasional' => 'Senin-Sabtu, 08.00-17.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                    [
                        'nama_fasilitas' => 'Gedung Olahraga',
                        'deskripsi' => 'Contoh fasilitas untuk kegiatan olahraga dan acara komunitas.',
                        'persyaratan' => 'Surat permohonan dan identitas peminjam.',
                        'tarif' => 500000,
                        'jadwal_operasional' => 'Senin-Sabtu, 08.00-17.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                    [
                        'nama_fasilitas' => 'Lapangan Bulu Tangkis',
                        'deskripsi' => 'Contoh fasilitas untuk kegiatan olahraga bulu tangkis.',
                        'persyaratan' => 'Identitas peminjam dan surat permohonan.',
                        'tarif' => 50000,
                        'jadwal_operasional' => 'Senin-Minggu, 08.00-21.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                ],
            ],
            [
                'nama_instansi' => 'Dinas Pendidikan Kota Palu',
                'alamat' => 'Kota Palu, Sulawesi Tengah',
                'email' => 'disdik@example.com',
                'no_telepon' => '0451-000002',
                'fasilitas' => [
                    [
                        'nama_fasilitas' => 'Aula Kegiatan Pendidikan',
                        'deskripsi' => 'Contoh ruang untuk seminar dan kegiatan pendidikan.',
                        'persyaratan' => 'Surat permohonan dan identitas peminjam.',
                        'tarif' => 250000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                    [
                        'nama_fasilitas' => 'Ruang Pelatihan',
                        'deskripsi' => 'Contoh ruang untuk pelatihan dan kegiatan pembelajaran.',
                        'persyaratan' => 'Surat permohonan dan rincian kegiatan.',
                        'tarif' => 100000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                ],
            ],
            [
                'nama_instansi' => 'Dinas Kearsipan dan Perpustakaan Kota Palu',
                'alamat' => 'Kota Palu, Sulawesi Tengah',
                'email' => 'perpustakaan@example.com',
                'no_telepon' => '0451-000003',
                'fasilitas' => [
                    [
                        'nama_fasilitas' => 'Ruang Diskusi',
                        'deskripsi' => 'Contoh ruang untuk diskusi dan belajar kelompok.',
                        'persyaratan' => 'Identitas peminjam dan tujuan penggunaan.',
                        'tarif' => 50000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                    [
                        'nama_fasilitas' => 'Ruang Kegiatan Literasi',
                        'deskripsi' => 'Contoh ruang untuk kegiatan membaca dan literasi.',
                        'persyaratan' => 'Surat permohonan dan rincian kegiatan.',
                        'tarif' => 100000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                ],
            ],
            [
                'nama_instansi' => 'Dinas Pariwisata Kota Palu',
                'alamat' => 'Kota Palu, Sulawesi Tengah',
                'email' => 'pariwisata@example.com',
                'no_telepon' => '0451-000004',
                'fasilitas' => [
                    [
                        'nama_fasilitas' => 'Ruang Kegiatan Komunitas',
                        'deskripsi' => 'Contoh ruang untuk kegiatan komunitas dan promosi pariwisata.',
                        'persyaratan' => 'Surat permohonan dan proposal kegiatan.',
                        'tarif' => 200000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                    [
                        'nama_fasilitas' => 'Ruang Pertemuan Pariwisata',
                        'deskripsi' => 'Contoh ruang untuk rapat dan kegiatan promosi wisata.',
                        'persyaratan' => 'Surat permohonan dan identitas peminjam.',
                        'tarif' => 150000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kota Palu, Sulawesi Tengah',
                    ],
                ],
            ],
            [
                'nama_instansi' => 'Kecamatan Mantikulore',
                'alamat' => 'Kecamatan Mantikulore, Kota Palu, Sulawesi Tengah',
                'email' => 'mantikulore@example.com',
                'no_telepon' => '0451-000005',
                'fasilitas' => [
                    [
                        'nama_fasilitas' => 'Aula Pertemuan Warga',
                        'deskripsi' => 'Contoh aula untuk rapat dan kegiatan masyarakat.',
                        'persyaratan' => 'Surat permohonan dan identitas peminjam.',
                        'tarif' => 100000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kecamatan Mantikulore, Kota Palu',
                    ],
                    [
                        'nama_fasilitas' => 'Ruang Rapat',
                        'deskripsi' => 'Contoh ruang untuk rapat organisasi dan komunitas.',
                        'persyaratan' => 'Surat permohonan dan rincian kegiatan.',
                        'tarif' => 75000,
                        'jadwal_operasional' => 'Senin-Jumat, 08.00-16.00',
                        'lokasi' => 'Kecamatan Mantikulore, Kota Palu',
                    ],
                ],
            ],
        ];

        foreach ($data as $item) {
            DB::transaction(function () use ($item) {
                $now = now();

                DB::table('instansi')->updateOrInsert(
                    ['nama_instansi' => $item['nama_instansi']],
                    [
                        'alamat' => $item['alamat'],
                        'email' => $item['email'],
                        'no_telepon' => $item['no_telepon'],
                        'updated_at' => $now,
                        'created_at' => $now,
                    ]
                );

                $instansiId = DB::table('instansi')
                    ->where('nama_instansi', $item['nama_instansi'])
                    ->value('id');

                foreach ($item['fasilitas'] as $fasilitas) {
                    DB::table('fasilitas')->updateOrInsert(
                        [
                            'instansi_id' => $instansiId,
                            'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                        ],
                        [
                            'deskripsi' => $fasilitas['deskripsi'],
                            'persyaratan' => $fasilitas['persyaratan'],
                            'tarif' => $fasilitas['tarif'],
                            'jadwal_operasional' => $fasilitas['jadwal_operasional'],
                            'template_surat' => null,
                            'lokasi' => $fasilitas['lokasi'],
                            'foto' => null,
                            'aktif' => true,
                            'updated_at' => $now,
                            'created_at' => $now,
                        ]
                    );
                }
            });
        }
    }
}
