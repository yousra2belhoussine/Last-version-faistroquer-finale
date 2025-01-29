<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Proposition;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propositions = Proposition::all();

        foreach ($propositions as $proposition) {
            // 70% chance of having messages
            if (rand(1, 100) <= 70) {
                // Generate 2-6 messages per proposition
                $numMessages = rand(2, 6);
                $currentDate = $proposition->created_at;
                
                for ($i = 0; $i < $numMessages; $i++) {
                    // Alternate between proposition user and ad owner
                    $sender = $i % 2 === 0 ? $proposition->user : $proposition->ad->user;
                    $receiver = $i % 2 === 0 ? $proposition->ad->user : $proposition->user;
                    
                    Message::create([
                        'sender_id' => $sender->id,
                        'receiver_id' => $receiver->id,
                        'proposition_id' => $proposition->id,
                        'content' => $this->getRandomMessage($i, $proposition->status),
                        'type' => 'direct',
                        'created_at' => $currentDate->addHours(rand(1, 12)),
                    ]);
                }
            }
        }

        // Create some contact form messages
        $admins = User::where('is_admin', true)->get();
        for ($i = 0; $i < 10; $i++) {
            Message::create([
                'sender_name' => "Contact User {$i}",
                'sender_email' => "contact{$i}@example.com",
                'receiver_id' => $admins->random()->id,
                'subject' => $this->getRandomContactSubject(),
                'content' => $this->getRandomContactMessage(),
                'type' => 'contact',
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
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
            'Désolé, mais je ne suis pas intéressé.',
            'Je préfère décliner votre proposition.',
            'Merci, mais ce n\'est pas ce que je recherche.',
            'Je suis navré, mais je dois refuser.',
        ];

        return $messages[array_rand($messages)];
    }

    private function getRandomNegotiationMessage(): string
    {
        $messages = [
            'Pouvez-vous m\'en dire plus sur l\'état de l\'objet ?',
            'Seriez-vous disponible ce weekend ?',
            'Je peux vous proposer un autre objet si vous préférez.',
            'Est-ce possible d\'avoir des photos supplémentaires ?',
        ];

        return $messages[array_rand($messages)];
    }

    private function getRandomContactSubject(): string
    {
        $subjects = [
            'Question sur le fonctionnement',
            'Problème technique',
            'Signalement d\'un utilisateur',
            'Suggestion d\'amélioration',
            'Demande d\'information',
        ];

        return $subjects[array_rand($subjects)];
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