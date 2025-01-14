<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataStudi extends Model
{
    use HasFactory;

    protected $table = "mata_studi";
    protected $primaryKey = "id_mata_studi";

    protected $fillable =[
        'nm_mata_studi',
    ];
}
