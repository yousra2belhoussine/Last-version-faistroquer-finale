<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Ad;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Créer des utilisateurs de test
        $users = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Créer des catégories de test
        $categories = [
            ['name' => 'Électronique', 'slug' => 'electronique'],
            ['name' => 'Vêtements', 'slug' => 'vetements'],
            ['name' => 'Livres', 'slug' => 'livres'],
            ['name' => 'Sports', 'slug' => 'sports']
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Créer des annonces de test
        $ads = [
            [
                'title' => 'iPhone 12 à échanger',
                'description' => 'iPhone 12 en très bon état à échanger contre un Android haut de gamme',
                'category_id' => 1,
                'user_id' => 1,
                'status' => 'active',
                'condition' => 'good',
                'exchange_type' => 'exchange',
            ],
            [
                'title' => 'Collection de livres Harry Potter',
                'description' => 'Collection complète des livres Harry Potter en français',
                'category_id' => 3,
                'user_id' => 2,
                'status' => 'active',
                'condition' => 'excellent',
                'exchange_type' => 'give',
            ],
            [
                'title' => 'Raquette de tennis',
                'description' => 'Raquette de tennis professionnelle peu utilisée',
                'category_id' => 4,
                'user_id' => 3,
                'status' => 'active',
                'condition' => 'good',
                'exchange_type' => 'exchange',
            ]
        ];

        foreach ($ads as $adData) {
            Ad::create($adData);
        }

        // Créer des conversations et messages de test
        $conversation1 = Conversation::create(['type' => 'private']);
        $conversation1->participants()->attach([
            1 => ['role' => 'member'],
            2 => ['role' => 'member']
        ]);

        $messages1 = [
            [
                'sender_id' => 1,
                'content' => 'Bonjour, je suis intéressé par votre collection Harry Potter',
                'created_at' => now()->subHours(2)
            ],
            [
                'sender_id' => 2,
                'content' => 'Bonjour ! Oui, elle est toujours disponible',
                'created_at' => now()->subHours(1)
            ],
            [
                'sender_id' => 1,
                'content' => 'Super ! Pourrions-nous organiser un échange ?',
                'created_at' => now()->subMinutes(30)
            ]
        ];

        foreach ($messages1 as $messageData) {
            Message::create([
                'conversation_id' => $conversation1->id,
                'sender_id' => $messageData['sender_id'],
                'content' => $messageData['content'],
                'created_at' => $messageData['created_at'],
                'updated_at' => $messageData['created_at']
            ]);
        }

        // Créer une deuxième conversation
        $conversation2 = Conversation::create(['type' => 'private']);
        $conversation2->participants()->attach([
            2 => ['role' => 'member'],
            3 => ['role' => 'member']
        ]);

        Message::create([
            'conversation_id' => $conversation2->id,
            'sender_id' => 3,
            'content' => 'Bonjour, votre annonce est-elle toujours disponible ?',
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1)
        ]);
    }
} 