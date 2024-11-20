<?php

namespace Database\Factories;

use App\Models\StatusAbsensi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusAbsensi>
 */
class StatusAbsensiFactory extends Factory
{
    protected $model = StatusAbsensi::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status_absensi' => fake()->name()
        ];
    }
}
