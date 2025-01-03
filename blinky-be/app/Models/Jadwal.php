<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'hari',
        'pertemuan'
    ];

    public function kelas(): BelongsTo{
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function dosen(): BelongsTo{
        return $this->belongsTo(Dosen::class, 'id_dosen', 'id_dosen');
    }

    public function matkul(): BelongsTo{
        return $this->belongsTo(Matkul::class, 'id_matkul', 'id_matkul');
    }

    public function pertemuan(): HasMany{
        return $this->hasMany(Pertemuan::class, 'id_jadwal', 'id_jadwal');
    }
}
