<?php

namespace Database\Factories;

use App\Models\Pertemuan;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pertemuan>
 */
class PertemuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_jadwal' => Jadwal::inRandomOrder()->first()->id_jadwal,
            'tanggal_pertemuan' => fake()->date()
        ];
    }
}
