<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Nouveau membre',
                'description' => 'Bienvenue dans la communauté !',
                'type' => 'new_member',
            ],
            [
                'name' => 'Super vendeur',
                'description' => 'A réalisé plus de 10 ventes réussies',
                'type' => 'super_seller',
            ],
            [
                'name' => 'Expert',
                'description' => 'Membre actif depuis plus d\'un an',
                'type' => 'expert',
            ],
            [
                'name' => 'Éco-responsable',
                'description' => 'Contribue activement à l\'économie circulaire',
                'type' => 'eco_friendly',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
} 