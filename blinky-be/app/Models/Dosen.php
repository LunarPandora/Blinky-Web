<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = "dosen";
    protected $primaryKey = "id";

    protected $fillable =[
        'nm_dosen',
        'email_dosen',
        'pw_dosen',
        'nidn',
        'foto_dosen',
    ];
}
