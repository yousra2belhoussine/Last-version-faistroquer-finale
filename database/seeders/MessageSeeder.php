<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Proposition;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des conversations pour les admins
        $admins = User::where('is_admin', true)->get();
        
        // Pour chaque admin, créer une conversation système
        foreach ($admins as $admin) {
            $conversation = Conversation::create([
                'type' => 'system',
                'name' => 'Messages système'
            ]);

            // Attacher l'admin comme participant
            $conversation->participants()->attach([
                $admin->id => ['role' => 'admin']
            ]);

            // Créer quelques messages système
            for ($i = 0; $i < 5; $i++) {
                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => null,
                    'content' => $this->getRandomContactMessage(),
                    'type' => 'system',
                    'is_system_message' => true,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // Créer des conversations pour les propositions
        $propositions = Proposition::all();
        foreach ($propositions as $proposition) {
            // Créer une conversation pour la proposition
            $conversation = Conversation::create([
                'type' => 'private',
            ]);

            // Attacher les participants
            $conversation->participants()->attach([
                $proposition->user_id => ['role' => 'member'],
                $proposition->ad->user_id => ['role' => 'member']
            ]);

            // Créer quelques messages pour la conversation
            $numMessages = rand(3, 8);
            for ($i = 0; $i < $numMessages; $i++) {
                $sender = $i % 2 === 0 ? $proposition->user_id : $proposition->ad->user_id;
                
                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $sender,
                    'content' => $this->getRandomMessage($i, $proposition->status),
                    'type' => 'text',
                    'created_at' => $proposition->created_at->addHours($i * 2),
                ]);
            }
        }
    }

    /**
     * Get a random message based on the position in conversation and proposition status.
     */
    private function getRandomMessage(int $position, string $status): string
    {
        if ($position === 0) {
            return $this->getRandomFirstMessage();
        } elseif ($status === 'accepted') {
            return $this->getRandomAcceptedMessage();
        } elseif ($status === 'rejected') {
            return $this->getRandomRejectedMessage();
        } else {
            return $this->getRandomNegotiationMessage();
        }
    }

    private function getRandomFirstMessage(): string
    {
        $messages = [
            'Bonjour, je suis intéressé par votre annonce. Pouvons-nous en discuter ?',
            'Bonjour, votre annonce m\'intéresse. L\'objet est-il toujours disponible ?',
            'Bonjour, je souhaiterais avoir plus d\'informations sur votre annonce.',
            'Bonjour, je suis intéressé par un échange. Pouvons-nous en parler ?',
        ];

        return $messages[array_rand($messages)];
    }

    private function getRandomAcceptedMessage(): string
    {
        $messages = [
            'Super ! Où pourrions-nous nous rencontrer ?',
            'Parfait ! Quel jour vous conviendrait le mieux ?',
            'Excellent ! Je suis disponible en semaine après 18h.',
            'Génial ! On peut se retrouver en ville si vous voulez.',
        ];

        return $messages[array_rand($messages)];
    }

    private function getRandomRejectedMessage(): string
    {
        $messages = [
            'Je suis désolé, mais je ne suis pas intéressé.',
            'Merci de votre proposition, mais je dois décliner.',
            'Désolé, mais ce n\'est pas ce que je recherche.',
            'Je ne pense pas que cela corresponde à mes attentes.',
        ];

        return $messages[array_rand($messages)];
    }

    private function getRandomNegotiationMessage(): string
    {
        $messages = [
            'Pourrions-nous trouver un arrangement ?',
            'Que pensez-vous de cette proposition ?',
            'Je peux vous proposer autre chose en échange.',
            'Seriez-vous ouvert à une contre-proposition ?',
        ];

        return $messages[array_rand($messages)];
    }

    private function getRandomContactMessage(): string
    {
        $messages = [
            'Bonjour, j\'aimerais savoir comment fonctionne le système d\'échange.',
            'J\'ai rencontré un problème lors de la création de mon annonce.',
            'Je souhaite signaler un comportement inapproprié.',
            'J\'ai une suggestion pour améliorer la plateforme.',
            'Pouvez-vous m\'aider avec mon compte ?',
        ];

        return $messages[array_rand($messages)];
    }
} 