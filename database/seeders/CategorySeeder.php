<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Catégories principales pour les objets
            ['name' => 'Électronique & Multimédia', 'slug' => 'electronique-multimedia', 'type' => 'object'],
            ['name' => 'Mode & Accessoires', 'slug' => 'mode-accessoires', 'type' => 'object'],
            ['name' => 'Maison & Décoration', 'slug' => 'maison-decoration', 'type' => 'object'],
            ['name' => 'Sports & Loisirs', 'slug' => 'sports-loisirs', 'type' => 'object'],
            ['name' => 'Culture & Divertissement', 'slug' => 'culture-divertissement', 'type' => 'object'],
            ['name' => 'Bricolage & Jardinage', 'slug' => 'bricolage-jardinage', 'type' => 'object'],
            ['name' => 'Enfants & Bébés', 'slug' => 'enfants-bebes', 'type' => 'object'],
            ['name' => 'Collection & Art', 'slug' => 'collection-art', 'type' => 'object'],
            
            // Catégories pour les services
            ['name' => 'Cours & Formation', 'slug' => 'cours-formation', 'type' => 'service'],
            ['name' => 'Bricolage & Travaux', 'slug' => 'bricolage-travaux', 'type' => 'service'],
            ['name' => 'Garde & Aide à domicile', 'slug' => 'garde-aide-domicile', 'type' => 'service'],
            ['name' => 'Transport & Covoiturage', 'slug' => 'transport-covoiturage', 'type' => 'service'],
            ['name' => 'Événements & Animation', 'slug' => 'evenements-animation', 'type' => 'service'],
            ['name' => 'Informatique & Numérique', 'slug' => 'informatique-numerique', 'type' => 'service'],
            
            // Catégories pour les articles/blog
            ['name' => 'Actualités Troc', 'slug' => 'actualites-troc', 'type' => 'article'],
            ['name' => 'Conseils & Astuces', 'slug' => 'conseils-astuces', 'type' => 'article'],
            ['name' => 'Témoignages', 'slug' => 'temoignages', 'type' => 'article'],
            ['name' => 'Événements', 'slug' => 'evenements', 'type' => 'article']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 