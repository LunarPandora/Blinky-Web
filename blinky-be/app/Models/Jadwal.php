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
        'id_pengajar',
        'id_mata_studi',
        'jam_mulai',
        'jam_selesai',
        'hari',
        'pertemuan'
    ];

    public function kelas(): BelongsTo{
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function pengajar(): BelongsTo{
        return $this->belongsTo(Pengajar::class, 'id_pengajar', 'id_pengajar');
    }

    public function mata_studi(): BelongsTo{
        return $this->belongsTo(MataStudi::class, 'id_mata_studi', 'id_mata_studi');
    }

    public function pertemuan(): HasMany{
        return $this->hasMany(Pertemuan::class, 'id_jadwal', 'id_jadwal');
    }
}
