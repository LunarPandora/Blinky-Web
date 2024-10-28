<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = "absensi";
    protected $primaryKey = "id_absensi";

    protected $fillable =[
        'id_mhswa',
        'id_jadwal',
        'waktu_absen',
        'kode_status_absensi'
    ];
}
