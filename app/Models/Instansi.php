<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instansi extends Model
{
    protected $table = 'instansi';

    protected $fillable = [
        'nama_instansi',
        'alamat',
        'email',
        'no_telepon',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function fasilitas(): HasMany
    {
        return $this->hasMany(Fasilitas::class);
    }
}
