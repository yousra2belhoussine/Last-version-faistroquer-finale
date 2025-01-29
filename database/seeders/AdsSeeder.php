<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdsSeeder extends Seeder
{
    public function run()
    {
        Ad::factory()->count(20)->create(); // Crée 20 annonces de test
    }
} 