<?php

namespace Database\Factories;

use App\Models\Matkul;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matkul>
 */
class MatkulFactory extends Factory
{
    protected $model = Matkul::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nm_matkul' => fake()->jobTitle()
        ];
    }
}
