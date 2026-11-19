
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                ->constrained('peminjaman')
                ->cascadeOnDelete();

            $table->string('nama_file');
            $table->string('path_file');
            $table->text('catatan_perbaikan')->nullable();

            $table->enum('status', [
                'menunggu_pemeriksaan',
                'perlu_perbaikan',
                'valid',
                'ditolak',
            ])->default('menunggu_pemeriksaan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_peminjaman');
    }
};
