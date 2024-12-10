<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\StatusAbsensi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absensi>
 */
class AbsensiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_kelas' => Kelas::inRandomOrder()->first()->id_kelas,
            'id_mhswa' => Mahasiswa::inRandomOrder()->first()->id_mhswa,
            'id_pertemuan' => Pertemuan::inRandomOrder()->first()->id_pertemuan,
            'kode_status_absensi' => StatusAbsensi::inRandomOrder()->first()->kode_status_absensi,
            'waktu_absen' => fake()->date()
        ];
    }
}
