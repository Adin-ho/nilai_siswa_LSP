<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'guru_id',
        'keterangan',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
