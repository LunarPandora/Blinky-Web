<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Prodi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
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
            'id_prodi' => Prodi::inRandomOrder()->first()->id_prodi,
            'nim' => fake()->randomNumber(8, true),
            'nm_mhswa' => fake()->name(),
            'angkatan' => fake()->year(),
            'uid_rfid' => fake()->randomNumber(8, true)
        ];
    }
}
