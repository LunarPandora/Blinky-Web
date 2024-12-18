<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Prodi;

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
    ];

    public function prodi(): BelongsTo{
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }
}
