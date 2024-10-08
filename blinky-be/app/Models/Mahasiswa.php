<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primaryKey = "id";

    protected $fillable =[
        'id_kelas',
        'id_prodi',
        'id_admin',
        'nm_mhswa',
        'angkatan',
        'foto_mhswa',
    ];
}
