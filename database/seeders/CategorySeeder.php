<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Électronique', 'slug' => 'electronique'],
            ['name' => 'Vêtements', 'slug' => 'vetements'],
            ['name' => 'Livres', 'slug' => 'livres'],
            ['name' => 'Sports & Loisirs', 'slug' => 'sports-loisirs'],
            ['name' => 'Maison', 'slug' => 'maison'],
            ['name' => 'Jardin', 'slug' => 'jardin'],
            ['name' => 'Véhicules', 'slug' => 'vehicules'],
            ['name' => 'Jeux & Jouets', 'slug' => 'jeux-jouets'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 