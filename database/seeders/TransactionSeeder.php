<?php

namespace Database\Seeders;

use App\Models\Proposition;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acceptedPropositions = Proposition::where('status', 'accepted')->get();

        foreach ($acceptedPropositions as $proposition) {
            // 80% chance of creating a transaction for accepted propositions
            if (rand(1, 100) <= 80) {
                $statuses = ['pending', 'completed', 'completed', 'cancelled'];
                $status = $statuses[array_rand($statuses)];
                
                $transaction = Transaction::create([
                    'proposition_id' => $proposition->id,
                    'status' => $status,
                    'meeting_date' => $proposition->accepted_at->addDays(rand(1, 7)),
                    'meeting_location' => $this->getRandomLocation(),
                    'created_at' => $proposition->accepted_at,
                ]);

                if ($status === 'completed') {
                    $transaction->completed_at = $transaction->meeting_date->addHours(rand(1, 3));
                    $transaction->save();
                } elseif ($status === 'cancelled') {
                    $transaction->cancelled_at = $transaction->created_at->addDays(rand(1, 3));
                    $transaction->cancellation_reason = $this->getRandomCancellationReason();
                    $transaction->cancelled_by = rand(0, 1) ? $proposition->user_id : $proposition->ad->user_id;
                    $transaction->save();
                }
            }
        }
    }

    /**
     * Get a random meeting location.
     */
    private function getRandomLocation(): string
    {
        $locations = [
            'Place de la République',
            'Gare Centrale',
            'Centre Commercial',
            'Parking du Supermarché',
            'Mairie',
            'Place du Marché',
            'Parc Municipal',
            'Station de Métro',
            'Café du Centre',
            'Médiathèque',
        ];

        return $locations[array_rand($locations)];
    }

    /**
     * Get a random cancellation reason.
     */
    private function getRandomCancellationReason(): string
    {
        $reasons = [
            'Empêchement de dernière minute',
            'Problème de transport',
            'Changement d\'avis sur l\'échange',
            'Objet plus disponible',
            'Désaccord sur les conditions',
            'Retard important',
            'Problème de communication',
            'Autre opportunité',
        ];

        return $reasons[array_rand($reasons)];
    }
} 