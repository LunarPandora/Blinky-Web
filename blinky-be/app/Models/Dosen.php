<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Prodi;
use App\Models\User;

class Dosen extends Model
{
    use HasFactory;

    protected $table = "dosen";
    protected $primaryKey = "id_dosen";

    protected $fillable = [
        'id_prodi',
        'nm_dosen',
        'jabatan',
        'nidn',
        'isActive',
        'no_telp',
        'alamat',
        'gender',
        'agama'
    ];

    public function prodi(): BelongsTo{
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function acc(): HasMany{
        return $this->hasMany(User::class, 'dosen_id', 'id_dosen');
    }
}
