<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\StatusAbsensi;

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
        'pertemuan',
        'keterangan'
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

    public function status(): HasMany{
        return $this->hasMany(StatusAbsensi::class, 'kode_status_absensi', 'kode_status_absensi');
    }
}
