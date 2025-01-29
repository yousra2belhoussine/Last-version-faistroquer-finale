<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(5, 1000),
            'status' => $this->faker->randomElement(['disponible', 'réservé', 'vendu']),
            'user_id' => User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
            'department' => $this->faker->numberBetween(1, 95),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Ad $ad) {
            // Créer quelques images pour chaque annonce
            for ($i = 0; $i < 3; $i++) {
                $ad->images()->create([
                    'image_path' => 'images/default-ad-image.jpg',
                ]);
            }
        });
    }
} 