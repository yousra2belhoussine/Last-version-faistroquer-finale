<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Électronique' => [
                'Smartphones', 'Ordinateurs', 'Tablettes', 'Accessoires Tech',
                'Consoles de jeux', 'TV & Home Cinéma'
            ],
            'Mode' => [
                'Vêtements', 'Chaussures', 'Accessoires Mode', 'Bijoux',
                'Montres', 'Sacs'
            ],
            'Maison' => [
                'Meubles', 'Décoration', 'Électroménager', 'Jardin',
                'Bricolage', 'Cuisine'
            ],
            'Sports & Loisirs' => [
                'Équipement sportif', 'Instruments de musique', 'Livres',
                'Jeux & Jouets', 'Art & Collections'
            ],
            'Services' => [
                'Cours particuliers', 'Services Bricolage', 'Services Jardinage',
                'Services Informatique', 'Organisation Événements', 'Transport'
            ]
        ];

        foreach ($categories as $mainCategory => $subCategories) {
            $parent = Category::create([
                'name' => $mainCategory,
                'slug' => Str::slug($mainCategory),
                'parent_id' => null
            ]);

            foreach ($subCategories as $subCategory) {
                Category::create([
                    'name' => $subCategory,
                    'slug' => Str::slug($mainCategory . '-' . $subCategory),
                    'parent_id' => $parent->id
                ]);
            }
        }
    }
} 