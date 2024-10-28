<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = "dosen";
    protected $primaryKey = "id_dosen";

    protected $fillable =[
        'id_prodi',
        'nm_dosen',
        'nidn',
        'id_jabatan',
        'u_dosen',
        'pw_dosen',
        // 'foto_dosen',
    ];
}
