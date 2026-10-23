<?php

namespace App\Models;

use Sakuci\Database\Model;

class Profile extends Model
{
    protected static ?string $table = 'profile';
    protected string $primaryKey = 'id_profile';
    
    protected array $fillable = [
        'id_user',
        'nama_lengkap',
        'nomor_telepon',
        'kelas',
        'alamat'
    ];
}