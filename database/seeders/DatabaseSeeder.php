<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,          // Créer l'administrateur
            RegionSeeder::class,         // Créer les régions et départements
            CategorySeeder::class,       // Créer les catégories
            UserAndAdSeeder::class,      // Créer les utilisateurs et annonces
            ExchangeAndMessageSeeder::class, // Créer les échanges et messages
        ]);
    }
}
