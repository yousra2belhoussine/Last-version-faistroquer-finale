<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class MessageTestSeeder extends Seeder
{
    public function run()
    {
        // Créer deux utilisateurs de test
        $user1 = User::create([
            'name' => 'Alice Test',
            'email' => 'alice@test.com',
            'password' => Hash::make('password123'),
        ]);

        $user2 = User::create([
            'name' => 'Bob Test',
            'email' => 'bob@test.com',
            'password' => Hash::make('password123'),
        ]);

        // Créer une conversation entre les deux utilisateurs
        $conversation = Conversation::create([
            'type' => 'private'
        ]);

        // Ajouter les participants à la conversation
        $conversation->participants()->attach([
            $user1->id => ['role' => 'member'],
            $user2->id => ['role' => 'member']
        ]);

        // Simuler une conversation
        $messages = [
            [
                'sender_id' => $user1->id,
                'content' => 'Bonjour Bob ! Comment vas-tu ?',
                'created_at' => now()->subMinutes(30)
            ],
            [
                'sender_id' => $user2->id,
                'content' => 'Salut Alice ! Je vais très bien, merci. Et toi ?',
                'created_at' => now()->subMinutes(25)
            ],
            [
                'sender_id' => $user1->id,
                'content' => 'Super bien ! Je voulais te demander quelque chose...',
                'created_at' => now()->subMinutes(20)
            ],
            [
                'sender_id' => $user2->id,
                'content' => 'Bien sûr, je t\'écoute !',
                'created_at' => now()->subMinutes(18)
            ],
            [
                'sender_id' => $user1->id,
                'content' => 'Est-ce que tu serais disponible pour une réunion demain ?',
                'created_at' => now()->subMinutes(15)
            ],
            [
                'sender_id' => $user2->id,
                'content' => 'Oui, parfait ! Quelle heure te conviendrait ?',
                'created_at' => now()->subMinutes(10)
            ],
            [
                'sender_id' => $user1->id,
                'content' => 'Que dirais-tu de 14h ?',
                'created_at' => now()->subMinutes(5)
            ],
            [
                'sender_id' => $user2->id,
                'content' => '14h me convient parfaitement ! À demain alors 😊',
                'created_at' => now()->subMinutes(2)
            ]
        ];

        // Créer les messages
        foreach ($messages as $messageData) {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $messageData['sender_id'],
                'content' => $messageData['content'],
                'created_at' => $messageData['created_at'],
                'updated_at' => $messageData['created_at']
            ]);
        }

        // Créer une deuxième conversation avec un seul message
        $conversation2 = Conversation::create([
            'type' => 'private'
        ]);

        $conversation2->participants()->attach([
            $user1->id => ['role' => 'member'],
            $user2->id => ['role' => 'member']
        ]);

        Message::create([
            'conversation_id' => $conversation2->id,
            'sender_id' => $user2->id,
            'content' => 'Hey Alice, as-tu reçu mon email ?',
            'created_at' => now()->subHours(1),
            'updated_at' => now()->subHours(1)
        ]);
    }
} 