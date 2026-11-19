
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                ->unique()
                ->constrained('peminjaman')
                ->cascadeOnDelete();

            $table->decimal('jumlah_bayar', 12, 2);
            $table->string('bukti_pembayaran')->nullable();

            $table->enum('status', [
                'belum_bayar',
                'menunggu_verifikasi',
                'terverifikasi',
                'ditolak',
            ])->default('belum_bayar');

            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
