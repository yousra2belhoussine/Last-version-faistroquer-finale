<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserAndAdSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');
        
        // Créer des utilisateurs particuliers
        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'type' => 'particular',
                'is_validated' => true,
                'phone' => $faker->phoneNumber,
                'bio' => $faker->text(200),
                'email_verified_at' => now(),
            ]);
        }

        // Créer des utilisateurs professionnels
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'type' => 'professional',
                'is_validated' => $faker->boolean(70),
                'company_name' => $faker->company,
                'siret' => $faker->numerify('##############'),
                'phone' => $faker->phoneNumber,
                'bio' => $faker->text(200),
                'email_verified_at' => now(),
            ]);
        }

        // Récupérer les IDs nécessaires
        $userIds = User::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();
        $regionIds = Region::pluck('id')->toArray();

        // Créer des annonces
        for ($i = 0; $i < 50; $i++) {
            Ad::create([
                'title' => $faker->sentence(6),
                'description' => $faker->paragraphs(3, true),
                'type' => $faker->randomElement(['good', 'service']),
                'status' => $faker->randomElement(['active', 'pending', 'paused']),
                'user_id' => $faker->randomElement($userIds),
                'category_id' => $faker->randomElement($categoryIds),
                'region_id' => $faker->randomElement($regionIds),
                'is_online' => $faker->boolean(80),
                'is_featured' => $faker->boolean(20),
                'views_count' => $faker->numberBetween(0, 1000),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
            ]);
        }
    }
} 