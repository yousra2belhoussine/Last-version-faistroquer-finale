<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Créer deux utilisateurs
        $user1 = User::create([
            'name' => 'User Test 1',
            'email' => 'user1@test.com',
            'password' => Hash::make('password'),
            'is_admin' => true
        ]);

        $user2 = User::create([
            'name' => 'User Test 2',
            'email' => 'user2@test.com',
            'password' => Hash::make('password'),
        ]);

        // S'assurer qu'il y a au moins une catégorie
        $categoryName = 'Catégorie Test';
        $category = Category::firstOrCreate([
            'name' => $categoryName,
            'slug' => Str::slug($categoryName)
        ]);

        // Créer une région
        $region = Region::firstOrCreate([
            'name' => 'Région Test',
            'slug' => 'region-test'
        ]);

        // Créer 4 articles
        for ($i = 1; $i <= 4; $i++) {
            Article::create([
                'title' => "Article Test $i",
                'content' => "Contenu de l'article test numéro $i",
                'user_id' => $i <= 2 ? $user1->id : $user2->id,
                'status' => 'approved',
                'category' => 'news'
            ]);
        }

        // Créer 4 annonces
        for ($i = 1; $i <= 4; $i++) {
            Ad::create([
                'title' => "Annonce Test $i",
                'description' => "Description de l'annonce test numéro $i",
                'user_id' => $i <= 2 ? $user1->id : $user2->id,
                'category_id' => $category->id,
                'region_id' => $region->id,
                'status' => 'active',
                'type' => $i % 2 == 0 ? 'goods' : 'services',
                'condition' => 'new'
            ]);
        }
    }
} 