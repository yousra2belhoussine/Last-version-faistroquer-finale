<?php

namespace Database\Seeders;

use App\Models\Dispute;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DisputeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::whereIn('status', ['pending', 'completed'])->get();

        foreach ($transactions as $transaction) {
            // 10% chance of having a dispute
            if (rand(1, 100) <= 10) {
                $status = ['pending', 'resolved', 'closed'][array_rand(['pending', 'resolved', 'closed'])];
                
                // Randomly choose who reports the dispute
                $reporter = rand(0, 1) ? $transaction->proposition->user : $transaction->proposition->ad->user;
                $reported = $reporter->id === $transaction->proposition->user_id 
                    ? $transaction->proposition->ad->user 
                    : $transaction->proposition->user;

                $dispute = Dispute::create([
                    'reporter_id' => $reporter->id,
                    'reported_id' => $reported->id,
                    'transaction_id' => $transaction->id,
                    'reason' => $this->getRandomReason(),
                    'description' => $this->getRandomDescription(),
                    'status' => $status,
                    'created_at' => $transaction->created_at->addDays(rand(1, 5)),
                ]);

                if ($status !== 'pending') {
                    $dispute->resolved_at = $dispute->created_at->addDays(rand(1, 3));
                    $dispute->resolution = $this->getRandomResolution();
                    $dispute->save();
                }
            }
        }
    }

    /**
     * Get a random dispute reason.
     */
    private function getRandomReason(): string
    {
        $reasons = [
            'no_show',
            'item_not_as_described',
            'inappropriate_behavior',
            'scam_attempt',
            'harassment',
            'other',
        ];

        return $reasons[array_rand($reasons)];
    }

    /**
     * Get a random dispute description.
     */
    private function getRandomDescription(): string
    {
        $descriptions = [
            'no_show' => [
                'La personne n\'est pas venue au rendez-vous sans prévenir.',
                'Après 30 minutes d\'attente, toujours personne.',
                'Absence au lieu de rendez-vous convenu.',
            ],
            'item_not_as_described' => [
                'L\'objet ne correspond pas du tout à la description.',
                'État bien plus dégradé que ce qui était annoncé.',
                'Caractéristiques différentes de l\'annonce.',
            ],
            'inappropriate_behavior' => [
                'Comportement agressif lors de la rencontre.',
                'Propos déplacés et irrespectueux.',
                'Attitude menaçante pendant l\'échange.',
            ],
            'scam_attempt' => [
                'Tentative d\'arnaque évidente.',
                'A essayé de modifier les termes de l\'échange au dernier moment.',
                'Demande de paiement supplémentaire non convenu.',
            ],
            'harassment' => [
                'Messages insistants et harcelants.',
                'Multiples tentatives de contact après refus.',
                'Comportement oppressant et intimidant.',
            ],
            'other' => [
                'Problème lors de l\'échange.',
                'Situation complexe nécessitant une médiation.',
                'Désaccord sur les conditions de l\'échange.',
            ],
        ];

        $reason = $this->getRandomReason();
        return $descriptions[$reason][array_rand($descriptions[$reason])];
    }

    /**
     * Get a random dispute resolution.
     */
    private function getRandomResolution(): string
    {
        $resolutions = [
            'Médiation réussie, les deux parties ont trouvé un accord.',
            'Avertissement donné à l\'utilisateur signalé.',
            'Échange annulé d\'un commun accord.',
            'Suspension temporaire de l\'utilisateur.',
            'Malentendu résolu après discussion.',
            'Compensation proposée et acceptée.',
        ];

        return $resolutions[array_rand($resolutions)];
    }
} 