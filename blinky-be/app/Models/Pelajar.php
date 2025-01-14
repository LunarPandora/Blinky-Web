<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Presensi;
use App\Models\User;

class Pelajar extends Model
{
    use HasFactory;

    protected $table = "pelajar";
    protected $primaryKey = "id_pelajar";

    protected $fillable =[
        'id_kelas',
        'id_jurusan',
        'nm_pelajar',
        'no_pelajar',
        'tipe_pelajar',
        'angkatan',
        'isActive',
        'no_telp',
        'alamat',
        'gender',
        'agama',
        'uid_rfid'
        // 'foto_pelajar',
    ];

    public function kelas(): BelongsTo{
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function jurusan(): BelongsTo{
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function presensi(): HasMany{
        return $this->hasMany(Presensi::class, 'id_pelajar', 'id_pelajar');
    }

    public function acc(): HasMany{
        return $this->hasMany(User::class, 'pelajar_id', 'id_pelajar');
    }
}
