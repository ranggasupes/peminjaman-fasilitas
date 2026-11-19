
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('fasilitas_id')
                ->constrained('fasilitas')
                ->restrictOnDelete();

            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->decimal('total_biaya', 12, 2)->default(0);

            $table->text('catatan_peminjam')->nullable();
            $table->text('catatan_admin')->nullable();

            $table->enum('status', [
                'diajukan',
                'perlu_perbaikan',
                'disetujui',
                'menunggu_pembayaran',
                'menunggu_verifikasi_pembayaran',
                'dikonfirmasi',
                'ditolak',
                'selesai',
                'dibatalkan',
            ])->default('diajukan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
