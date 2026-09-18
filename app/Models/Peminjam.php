<?php

namespace App\Models;

use Sakuci\Database\Model;

class Peminjam extends Model
{
    protected static ?string $table = 'peminjam';

    protected string $primaryKey = 'id_peminjam';

    protected array $fillable = [
        'id_user',
        'nis',
        'nama_peminjam',
        'kelas'
    ];
}
