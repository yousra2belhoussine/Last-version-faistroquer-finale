<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Proposition;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNotNull('email_verified_at')->get();
        $ads = Ad::where('status', 'active')->get();

        foreach ($ads as $ad) {
            // 30% chance of having propositions
            if (rand(1, 100) <= 30) {
                // Generate 1-3 propositions per ad
                $numPropositions = rand(1, 3);
                
                for ($i = 0; $i < $numPropositions; $i++) {
                    // Get a random user that's not the ad owner
                    $user = $users->where('id', '!=', $ad->user_id)->random();
                    
                    $status = ['pending', 'accepted', 'rejected', 'cancelled'][array_rand(['pending', 'accepted', 'rejected', 'cancelled'])];
                    
                    $proposition = Proposition::create([
                        'user_id' => $user->id,
                        'ad_id' => $ad->id,
                        'message' => $this->getRandomMessage(),
                        'status' => $status,
                        'price' => rand(10, 1000),
                        'created_at' => $ad->created_at->addDays(rand(1, 5)),
                    ]);

                    if ($status === 'accepted') {
                        $proposition->accepted_at = $proposition->created_at->addDays(rand(1, 3));
                        $proposition->save();
                    } elseif ($status === 'rejected') {
                        $proposition->rejected_at = $proposition->created_at->addDays(rand(1, 3));
                        $proposition->save();
                    }
                }
            }
        }
    }

    /**
     * Get a random proposition message.
     */
    private function getRandomMessage(): string
    {
        $messages = [
            'Je suis intéressé par votre annonce. Je propose un échange équitable.',
            'Votre objet m\'intéresse beaucoup. Voici ma proposition d\'échange.',
            'J\'ai exactement ce que vous recherchez. Discutons des détails.',
            'Je suis disponible pour un échange. Voici ce que je propose.',
            'Très intéressé par votre annonce. Étudions les possibilités d\'échange.',
        ];

        return $messages[array_rand($messages)];
    }
} 