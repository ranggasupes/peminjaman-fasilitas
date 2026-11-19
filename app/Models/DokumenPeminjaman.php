<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenPeminjaman extends Model
{
    protected $table = 'dokumen_peminjaman';

    protected $fillable = [
        'peminjaman_id',
        'nama_file',
        'path_file',
        'catatan_perbaikan',
        'status',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
