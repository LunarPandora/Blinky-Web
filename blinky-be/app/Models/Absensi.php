<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = "absensi";
    protected $primaryKey = "id_absensi"; 

    protected $fillable = [
        'id_mhswa',
        'id_kelas',
        'id_pertemuan',
        'waktu_absen',
        'kode_status_absensi',
        'pertemuan'
    ];

    public function kelas(): BelongsTo{
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function mahasiswa(): BelongsTo{
        return $this->belongsTo(Mahasiswa::class, 'id_mhswa', 'id_mhswa');
    }

    public function pertemuan(): BelongsTo{
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan', 'id_pertemuan');
    }
}
