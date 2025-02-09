<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\User;
use App\Models\Region;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $regions = Region::all();

        $ads = [
            [
                'title' => 'iPhone 12 Pro Max',
                'description' => 'iPhone 12 Pro Max 256GB en excellent état, débloqué tout opérateur',
                'type' => 'goods',
                'status' => 'active',
                'category_id' => $categories->where('slug', 'electronique')->first()->id,
                'region_id' => $regions->first()->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Vélo de route',
                'description' => 'Vélo de route taille M, parfait pour débuter',
                'type' => 'goods',
                'status' => 'active',
                'category_id' => $categories->where('slug', 'sports-loisirs')->first()->id,
                'region_id' => $regions->first()->id,
            ],
            [
                'title' => 'Collection Harry Potter',
                'description' => 'Collection complète des 7 tomes Harry Potter en français',
                'type' => 'goods',
                'status' => 'active',
                'category_id' => $categories->where('slug', 'livres')->first()->id,
                'region_id' => $regions->first()->id,
            ],
        ];

        foreach ($ads as $adData) {
            $ad = new Ad($adData);
            $ad->user_id = $users->random()->id;
            $ad->save();
        }
    }
} 