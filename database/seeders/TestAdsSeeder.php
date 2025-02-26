<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\User;
use App\Models\Region;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TestAdsSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer l'admin
        $admin = User::where('email', 'admin@example.com')->first();
        
        // Récupérer les catégories et régions
        $categories = Category::all();
        $regions = Region::all();

        // Créer les annonces de test
        $ads = [
            [
                'title' => 'Range Rover Sport HSE',
                'description' => 'Range Rover Sport HSE en excellent état. Couleur noire, intérieur cuir, toit panoramique, jantes 20 pouces. 
                                Équipements: GPS, caméra de recul, sièges chauffants, système audio premium.
                                Kilométrage: 75000 km
                                Année: 2019
                                Carburant: Diesel
                                Boîte automatique',
                'type' => 'goods',
                'status' => 'active',
                'exchange_with' => 'Recherche échange contre appartement ou terrain + soulte selon proposition',
                'price' => 55000,
                'city' => 'Paris',
                'department' => '75',
                'postal_code' => '75008',
                'category_id' => $categories->where('slug', 'mode-accessoires')->first()->id,
                'region_id' => $regions->first()->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Villa contemporaine avec piscine',
                'description' => 'Magnifique villa contemporaine de 200m² avec piscine chauffée.
                                4 chambres, 3 salles de bain, grand salon lumineux, cuisine équipée.
                                Jardin paysager de 1000m², garage double.
                                Prestations haut de gamme, domotique complète.',
                'type' => 'goods',
                'status' => 'active',
                'exchange_with' => 'Échange possible contre appartement de luxe à Paris ou maison similaire sur la Côte d\'Azur',
                'price' => 850000,
                'city' => 'Aix-en-Provence',
                'department' => '13',
                'postal_code' => '13100',
                'category_id' => $categories->where('slug', 'maison-decoration')->first()->id,
                'region_id' => $regions->first()->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Yacht Princess 62',
                'description' => 'Yacht Princess 62 en parfait état, année 2018.
                                Longueur: 19.30m, 3 cabines luxueuses.
                                Motorisation: 2 x MAN V8 1200
                                Équipements complets: GPS, radar, pilote automatique.
                                Faible consommation, idéal pour les croisières en famille.',
                'type' => 'goods',
                'status' => 'active',
                'exchange_with' => 'Échange contre bien immobilier de valeur équivalente ou voitures de collection',
                'price' => 1200000,
                'city' => 'Saint-Tropez',
                'department' => '83',
                'postal_code' => '83990',
                'category_id' => $categories->where('slug', 'sports-loisirs')->first()->id,
                'region_id' => $regions->first()->id,
                'is_featured' => true,
            ],
        ];

        // Créer les annonces et les associer à l'admin
        foreach ($ads as $adData) {
            $ad = new Ad($adData);
            $ad->user_id = $admin->id;
            $ad->save();
        }
    }
} 