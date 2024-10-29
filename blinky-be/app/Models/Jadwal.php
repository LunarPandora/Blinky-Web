<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = "jadwal";
    protected $primaryKey = "id_jadwal";

    protected $fillable = [
        'id_kelas',
        'id_dosen',
        'id_matkul',
        'jam_mulai',
        'jam_selesai',
        'hari'
    ];
}
