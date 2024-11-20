<?php

namespace Database\Seeders;

use App\Models\StatusAbsensi;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusAbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusAbsensi::factory(5)->create();
    }
}
