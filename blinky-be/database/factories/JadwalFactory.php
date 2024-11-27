<?php

namespace Database\Factories;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\Matkul;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jadwal>
 */
class JadwalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_kelas' => Kelas::inRandomOrder()->first()->id_kelas,
            'id_dosen' => Dosen::inRandomOrder()->first()->id_dosen,
            'id_matkul' => Matkul::inRandomOrder()->first()->id_matkul,
            'jam_mulai' => fake()->time(),
            'jam_selesai' => fake()->time(),
            'hari' => fake()->dayOfMonth(),
            'pertemuan' => fake()->randomNumber(2, true)
        ];
    }
}
