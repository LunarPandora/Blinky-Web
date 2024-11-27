<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Roles;
use App\Models\Dosen;
use App\Models\Mahasiswa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $isDosen = $this->faker->boolean();
        
        return [
            'role_id' => Roles::inRandomOrder()->first()->id,
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'dosen_id' => $isDosen ? Dosen::inRandomOrder()->first()->id_dosen : null,
            'mhswa_id' => !$isDosen ? Mahasiswa::inRandomOrder()->first()->id_mhswa : null,
            'user_picture' => fake()->word()
        ];
    }
}
