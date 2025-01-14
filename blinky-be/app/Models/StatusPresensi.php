<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPresensi extends Model
{
    use HasFactory;

    protected $table = "status_presensi";
    protected $primaryKey = "kode_status_presensi";

    protected $fillable = [
        'status_presensi',
    ];
}
