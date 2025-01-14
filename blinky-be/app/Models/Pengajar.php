<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Jurusan;
use App\Models\User;

class Pengajar extends Model
{
    use HasFactory;

    protected $table = "pengajar";
    protected $primaryKey = "id_pengajar";

    protected $fillable = [
        'id_jurusan',
        'nm_pengajar',
        'jabatan',
        'no_pengajar',
        'tipe_pengajar',
        'isActive',
        'no_telp',
        'alamat',
        'gender',
        'agama'
    ];

    public function jurusan(): BelongsTo{
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function acc(): HasMany{
        return $this->hasMany(User::class, 'pengajar_id', 'id_pengajar');
    }
}
