<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use Database\Factories\KelasFactory;

use App\Models\Pelajar;

class Kelas extends Model
{
    use HasFactory;

    protected $table = "kelas";
    protected $primaryKey = "id_kelas";

    protected $fillable =[
        'nm_kelas',
    ];

    public function pelajar(): HasMany{
        return $this->hasMany(Pelajar::class, 'id_kelas', 'id_kelas');
    }
}
