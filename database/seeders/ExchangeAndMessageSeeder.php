<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exchange;
use App\Models\Message;
use App\Models\User;
use App\Models\Ad;
use Faker\Factory as Faker;

class ExchangeAndMessageSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');
        
        // Récupérer les IDs nécessaires
        $userIds = User::pluck('id')->toArray();
        $adIds = Ad::pluck('id')->toArray();

        // Créer des échanges
        for ($i = 0; $i < 30; $i++) {
            $proposerId = $faker->randomElement($userIds);
            $ad = Ad::find($faker->randomElement($adIds));
            
            // S'assurer que le proposeur n'est pas le propriétaire de l'annonce
            while ($proposerId == $ad->user_id) {
                $proposerId = $faker->randomElement($userIds);
            }

            $exchange = Exchange::create([
                'proposer_id' => $proposerId,
                'receiver_id' => $ad->user_id,
                'ad_id' => $ad->id,
                'status' => $faker->randomElement(['pending', 'accepted', 'completed', 'rejected', 'cancelled']),
                'type' => $faker->randomElement(['direct', 'counter_offer']),
                'notes' => $faker->optional()->text(200),
                'meeting_date' => $faker->optional()->dateTimeBetween('now', '+2 months'),
                'meeting_location' => $faker->optional()->address,
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
            ]);

            // Créer des messages pour cet échange
            $messageCount = $faker->numberBetween(2, 8);
            $participants = [$exchange->proposer_id, $exchange->receiver_id];
            
            for ($j = 0; $j < $messageCount; $j++) {
                Message::create([
                    'sender_id' => $faker->randomElement($participants),
                    'receiver_id' => $faker->randomElement(array_diff($participants, [$participants[0]])),
                    'exchange_id' => $exchange->id,
                    'content' => $faker->text(200),
                    'read_at' => $faker->optional(0.7)->dateTimeBetween('-1 month', 'now'),
                    'created_at' => $faker->dateTimeBetween($exchange->created_at, 'now'),
                ]);
            }
        }
    }
} 