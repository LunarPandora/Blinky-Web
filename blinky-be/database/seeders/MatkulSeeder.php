<?php

namespace Database\Seeders;

use App\Models\Matkul;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Matkul::factory()->create();
    }
}
