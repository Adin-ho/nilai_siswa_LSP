<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    public function mataPelajarans()
    {
        return $this->hasMany(MataPelajaran::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}