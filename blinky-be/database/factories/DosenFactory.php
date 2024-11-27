<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_prodi' => Prodi::inRandomOrder()->first()->id_prodi,
            'nm_dosen' => fake()->name(),
            'jabatan' => fake()->jobTitle(),
            'nidn' => fake()->randomNumber(8, true)
        ];
    }
}
