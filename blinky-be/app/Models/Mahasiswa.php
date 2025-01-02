<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Absensi;
use App\Models\User;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primaryKey = "id_mhswa";

    protected $fillable =[
        'nim',
        'id_kelas',
        'id_prodi',
        'id_admin',
        'nm_mhswa',
        'angkatan',
        'uid_rfid',
        // 'foto_mhswa',
    ];

    public function kelas(): BelongsTo{
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function prodi(): BelongsTo{
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function absensi(): HasMany{
        return $this->hasMany(Absensi::class, 'id_mhswa', 'id_mhswa');
    }
}
