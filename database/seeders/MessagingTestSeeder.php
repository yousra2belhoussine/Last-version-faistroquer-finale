<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Carbon\Carbon;

class MessagingTestSeeder extends Seeder
{
    public function run()
    {
        // Créer quelques utilisateurs de test s'ils n'existent pas déjà
        $users = [
            [
                'name' => 'Alice Martin',
                'email' => 'alice@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Bob Dupont',
                'email' => 'bob@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Claire Dubois',
                'email' => 'claire@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'David Bernard',
                'email' => 'david@example.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Récupérer les utilisateurs créés
        $alice = User::where('email', 'alice@example.com')->first();
        $bob = User::where('email', 'bob@example.com')->first();
        $claire = User::where('email', 'claire@example.com')->first();
        $david = User::where('email', 'david@example.com')->first();

        // Créer des conversations
        // Conversation 1: Alice et Bob
        $conversation1 = Conversation::create(['type' => 'private']);
        $conversation1->participants()->attach([
            $alice->id,
            $bob->id
        ]);

        // Messages entre Alice et Bob
        Message::create([
            'conversation_id' => $conversation1->id,
            'sender_id' => $alice->id,
            'content' => 'Bonjour Bob, comment vas-tu ?',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        Message::create([
            'conversation_id' => $conversation1->id,
            'sender_id' => $bob->id,
            'content' => 'Salut Alice ! Je vais bien, merci. Et toi ?',
            'created_at' => Carbon::now()->subDays(2)->addMinutes(5),
        ]);

        // Conversation 2: Claire et David
        $conversation2 = Conversation::create(['type' => 'private']);
        $conversation2->participants()->attach([
            $claire->id,
            $david->id
        ]);

        Message::create([
            'conversation_id' => $conversation2->id,
            'sender_id' => $claire->id,
            'content' => 'Hey David, as-tu vu mon annonce pour l\'échange ?',
            'created_at' => Carbon::now()->subDay(),
        ]);

        // Conversation 3: Groupe de discussion
        $conversation3 = Conversation::create([
            'type' => 'group'
        ]);

        $conversation3->participants()->attach([
            $alice->id,
            $bob->id,
            $claire->id,
            $david->id
        ]);

        // Messages dans le groupe
        Message::create([
            'conversation_id' => $conversation3->id,
            'sender_id' => $alice->id,
            'content' => 'Bienvenue tout le monde dans notre groupe de discussion !',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        Message::create([
            'conversation_id' => $conversation3->id,
            'sender_id' => $bob->id,
            'content' => 'Merci pour l\'invitation Alice !',
            'created_at' => Carbon::now()->subDays(3)->addMinutes(2),
        ]);

        Message::create([
            'conversation_id' => $conversation3->id,
            'sender_id' => $claire->id,
            'content' => 'Super idée ce groupe !',
            'created_at' => Carbon::now()->subDays(3)->addMinutes(5),
        ]);

        // Conversation 4: Alice et Claire
        $conversation4 = Conversation::create(['type' => 'private']);
        $conversation4->participants()->attach([
            $alice->id,
            $claire->id
        ]);

        Message::create([
            'conversation_id' => $conversation4->id,
            'sender_id' => $alice->id,
            'content' => 'Claire, j\'aimerais discuter de ton dernier troc.',
            'created_at' => Carbon::now()->subHours(1),
        ]);

        $this->command->info('Données de test pour la messagerie créées avec succès !');
    }
} 