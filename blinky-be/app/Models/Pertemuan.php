<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = "pertemuan";
    protected $primaryKey = "id_pertemuan";

    protected $fillable =[
        'id_jadwal',
        'tanggal_pertemuan',
    ];

    public function jadwal(): BelongsTo{
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function presensi(): HasMany{
        return $this->hasMany(Presensi::class, 'id_pertemuan', 'id_pertemuan');
    }
}
