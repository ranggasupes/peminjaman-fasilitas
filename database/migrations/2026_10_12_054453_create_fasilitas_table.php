
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')
                ->constrained('instansi')
                ->cascadeOnDelete();

            $table->string('nama_fasilitas');
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->decimal('tarif', 12, 2)->default(0);
            $table->text('jadwal_operasional')->nullable();
            $table->string('template_surat')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
