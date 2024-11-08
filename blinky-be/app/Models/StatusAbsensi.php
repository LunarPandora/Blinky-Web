<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAbsensi extends Model
{
    use HasFactory;

    protected $table = "status_absensi";
    protected $primaryKey = "kode_status_absensi";

    protected $fillable = [
        'status_absensi',
    ];
}
