<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $completedTransactions = Transaction::where('status', 'completed')->get();

        foreach ($completedTransactions as $transaction) {
            // 90% chance of having reviews for completed transactions
            if (rand(1, 100) <= 90) {
                // Create review from proposition user
                Review::create([
                    'reviewer_id' => $transaction->proposition->user_id,
                    'reviewed_id' => $transaction->proposition->ad->user_id,
                    'transaction_id' => $transaction->id,
                    'rating' => $this->getWeightedRating(),
                    'comment' => $this->getRandomComment(),
                    'tags' => $this->getRandomTags(),
                    'created_at' => $transaction->completed_at->addHours(rand(1, 48)),
                ]);

                // Create review from ad owner
                Review::create([
                    'reviewer_id' => $transaction->proposition->ad->user_id,
                    'reviewed_id' => $transaction->proposition->user_id,
                    'transaction_id' => $transaction->id,
                    'rating' => $this->getWeightedRating(),
                    'comment' => $this->getRandomComment(),
                    'tags' => $this->getRandomTags(),
                    'created_at' => $transaction->completed_at->addHours(rand(1, 48)),
                ]);
            }
        }
    }

    /**
     * Get a weighted random rating (biased towards positive ratings).
     */
    private function getWeightedRating(): int
    {
        $weights = [
            5 => 40, // 40% chance
            4 => 35, // 35% chance
            3 => 15, // 15% chance
            2 => 7,  // 7% chance
            1 => 3,  // 3% chance
        ];

        $rand = rand(1, 100);
        $sum = 0;

        foreach ($weights as $rating => $weight) {
            $sum += $weight;
            if ($rand <= $sum) {
                return $rating;
            }
        }

        return 5;
    }

    /**
     * Get a random review comment.
     */
    private function getRandomComment(): string
    {
        $comments = [
            'Très bon échange, personne sérieuse et ponctuelle.',
            'Échange parfait, je recommande vivement !',
            'Très satisfait de l\'échange, merci beaucoup.',
            'Personne agréable et transaction rapide.',
            'Tout s\'est bien passé, échange au top !',
            'Communication facile et échange réussi.',
            'Super expérience, je n\'hésiterai pas à refaire un échange.',
            'Personne fiable et sympathique.',
            'Échange conforme à mes attentes.',
            'Très professionnel, merci !',
        ];

        return $comments[array_rand($comments)];
    }

    /**
     * Get random tags for the review.
     */
    private function getRandomTags(): array
    {
        $allTags = [
            'friendly',
            'punctual',
            'reliable',
            'professional',
            'good_communication',
        ];

        $numTags = rand(1, 3);
        shuffle($allTags);

        return array_slice($allTags, 0, $numTags);
    }
} 