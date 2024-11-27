<?php

namespace Database\Seeders;

use App\Models\Pertemuan;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PertemuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pertemuan::factory(5)->create();
    }
}
