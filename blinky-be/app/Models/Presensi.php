<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Kelas;
use App\Models\Pelajar;
use App\Models\Pertemuan;
use App\Models\StatusPresensi;

class Presensi extends Model
{
    use HasFactory;

    protected $table = "presensi";
    protected $primaryKey = "id_presensi"; 

    protected $fillable = [
        'id_pelajar',
        'id_kelas',
        'id_pertemuan',
        'waktu_presensi',
        'kode_status_presensi',
        'pertemuan',
        'keterangan'
    ];

    public function kelas(): BelongsTo{
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function pelajar(): BelongsTo{
        return $this->belongsTo(Pelajar::class, 'id_pelajar', 'id_pelajar');
    }

    public function pertemuan(): BelongsTo{
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan', 'id_pertemuan');
    }

    public function status(): HasMany{
        return $this->hasMany(StatusPresensi::class, 'kode_status_presensi', 'kode_status_presensi');
    }
}
