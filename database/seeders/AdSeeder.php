<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::whereNotNull('parent_id')->get();
        
        $titles = [
            'Véhicules' => [
                'Peugeot 208 en excellent état',
                'Vélo électrique peu utilisé',
                'Moto Yamaha MT-07',
                'Pièces détachées BMW',
            ],
            'Immobilier' => [
                'Appartement T3 lumineux',
                'Maison avec jardin',
                'Bureau 50m² centre-ville',
                'Garage fermé',
            ],
            'Multimédia' => [
                'iPhone 13 comme neuf',
                'PC Gamer haute performance',
                'PS5 avec 2 manettes',
                'iPad Pro 2022',
            ],
            'Maison' => [
                'Canapé cuir 3 places',
                'Machine à laver A+++',
                'Table à manger en chêne',
                'Outils de jardinage',
            ],
            'Mode' => [
                'Veste en cuir taille L',
                'Sac à main Louis Vuitton',
                'Montre connectée Samsung',
                'Chaussures Nike Air Max',
            ],
            'Loisirs' => [
                'Guitare électrique Fender',
                'Collection de timbres',
                'Raquette de tennis pro',
                'Console rétro Nintendo',
            ],
            'Services' => [
                'Cours de mathématiques',
                'Réparation smartphone',
                'Jardinage et entretien',
                'DJ pour événements',
            ],
        ];

        $descriptions = [
            'Véhicules' => [
                'Véhicule en parfait état, entretien régulier, faible kilométrage.',
                'Utilisé quelques mois seulement, comme neuf.',
                'Excellent état, révision récente, pneus neufs.',
                'Pièces d\'origine, prix négociable.',
            ],
            'Immobilier' => [
                'Bien situé, proche commerces et transports.',
                'Jardin arboré, quartier calme, belle exposition.',
                'Idéal pour profession libérale, parking inclus.',
                'Sécurisé, accès facile, disponible immédiatement.',
            ],
            'Multimédia' => [
                'Acheté il y a quelques mois, sous garantie.',
                'Configuration haut de gamme, idéal gaming.',
                'Peu utilisé, avec facture d\'achat.',
                'Parfait état, avec accessoires d\'origine.',
            ],
            'Maison' => [
                'Excellent état, peu utilisé.',
                'Classe énergétique A, garantie 2 ans.',
                'Bois massif, fabrication artisanale.',
                'Lot complet, parfait état.',
            ],
            'Mode' => [
                'Porté quelques fois, taille correcte.',
                'Authentique, avec certificat.',
                'Dernière génération, tous accessoires.',
                'Neuves, jamais portées.',
            ],
            'Loisirs' => [
                'Excellent son, parfait état.',
                'Collection rare et complète.',
                'Haut de gamme, peu utilisée.',
                'En état de marche, avec jeux.',
            ],
            'Services' => [
                'Professeur expérimenté, tous niveaux.',
                'Technicien qualifié, intervention rapide.',
                'Service professionnel, devis gratuit.',
                'Grande expérience, matériel fourni.',
            ],
        ];

        foreach ($users as $user) {
            // Each user creates 2-5 ads
            $numAds = rand(2, 5);
            
            for ($i = 0; $i < $numAds; $i++) {
                $category = $categories->random();
                $parentCategory = Category::find($category->parent_id);
                
                $title = $titles[$parentCategory->name][array_rand($titles[$parentCategory->name])];
                $description = $descriptions[$parentCategory->name][array_rand($descriptions[$parentCategory->name])];
                
                Ad::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $title,
                    'description' => $description,
                    'location' => 'Paris',
                    'type' => rand(0, 1) ? 'goods' : 'services',
                    'exchange_with' => 'Ouvert aux propositions',
                    'online_exchange' => rand(0, 1) ? true : false,
                    'status' => ['active', 'active', 'active', 'paused'][array_rand(['active', 'active', 'active', 'paused'])],
                    'expires_at' => now()->addDays(30),
                    'created_at' => now()->subDays(rand(1, 30)),
                    'is_featured' => rand(1, 5) === 1,
                ]);
            }
        }
    }
} 