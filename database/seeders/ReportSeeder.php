<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Report;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('status', 'active')->get();
        
        // Reports for ads (5% chance for each ad)
        $ads = Ad::where('status', 'active')->get();
        foreach ($ads as $ad) {
            if (rand(1, 100) <= 5) {
                $reporter = $users->where('id', '!=', $ad->user_id)->random();
                
                Report::create([
                    'reporter_id' => $reporter->id,
                    'reportable_type' => Ad::class,
                    'reportable_id' => $ad->id,
                    'reason' => $this->getRandomAdReason(),
                    'description' => $this->getRandomAdDescription(),
                    'status' => $this->getRandomStatus(),
                    'created_at' => $ad->created_at->addDays(rand(1, 10)),
                ]);
            }
        }

        // Reports for reviews (3% chance for each review)
        $reviews = Review::all();
        foreach ($reviews as $review) {
            if (rand(1, 100) <= 3) {
                $reporter = $users->where('id', '!=', $review->reviewer_id)
                                ->where('id', '!=', $review->reviewed_id)
                                ->random();
                
                Report::create([
                    'reporter_id' => $reporter->id,
                    'reportable_type' => Review::class,
                    'reportable_id' => $review->id,
                    'reason' => $this->getRandomReviewReason(),
                    'description' => $this->getRandomReviewDescription(),
                    'status' => $this->getRandomStatus(),
                    'created_at' => $review->created_at->addDays(rand(1, 5)),
                ]);
            }
        }

        // Reports for users (2% chance for each user)
        foreach ($users as $user) {
            if (rand(1, 100) <= 2) {
                $reporter = $users->where('id', '!=', $user->id)->random();
                
                Report::create([
                    'reporter_id' => $reporter->id,
                    'reportable_type' => User::class,
                    'reportable_id' => $user->id,
                    'reason' => $this->getRandomUserReason(),
                    'description' => $this->getRandomUserDescription(),
                    'status' => $this->getRandomStatus(),
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }

    private function getRandomStatus(): string
    {
        return ['pending', 'resolved', 'dismissed'][array_rand(['pending', 'resolved', 'dismissed'])];
    }

    private function getRandomAdReason(): string
    {
        return [
            'inappropriate_content',
            'misleading_information',
            'prohibited_item',
            'spam',
            'other',
        ][array_rand([
            'inappropriate_content',
            'misleading_information',
            'prohibited_item',
            'spam',
            'other',
        ])];
    }

    private function getRandomAdDescription(): string
    {
        return [
            'Cette annonce contient du contenu inapproprié.',
            'Les informations sont trompeuses ou fausses.',
            'Cet article est interdit à la vente/échange.',
            'Cette annonce semble être du spam.',
            'Annonce suspecte nécessitant une vérification.',
        ][array_rand([
            'Cette annonce contient du contenu inapproprié.',
            'Les informations sont trompeuses ou fausses.',
            'Cet article est interdit à la vente/échange.',
            'Cette annonce semble être du spam.',
            'Annonce suspecte nécessitant une vérification.',
        ])];
    }

    private function getRandomReviewReason(): string
    {
        return [
            'inappropriate_content',
            'false_information',
            'harassment',
            'spam',
            'other',
        ][array_rand([
            'inappropriate_content',
            'false_information',
            'harassment',
            'spam',
            'other',
        ])];
    }

    private function getRandomReviewDescription(): string
    {
        return [
            'Ce commentaire contient des propos inappropriés.',
            'Cette évaluation semble être fausse ou mensongère.',
            'Contenu harcelant ou menaçant.',
            'Avis spam ou non pertinent.',
            'Évaluation suspecte à vérifier.',
        ][array_rand([
            'Ce commentaire contient des propos inappropriés.',
            'Cette évaluation semble être fausse ou mensongère.',
            'Contenu harcelant ou menaçant.',
            'Avis spam ou non pertinent.',
            'Évaluation suspecte à vérifier.',
        ])];
    }

    private function getRandomUserReason(): string
    {
        return [
            'inappropriate_behavior',
            'suspicious_activity',
            'harassment',
            'scam',
            'other',
        ][array_rand([
            'inappropriate_behavior',
            'suspicious_activity',
            'harassment',
            'scam',
            'other',
        ])];
    }

    private function getRandomUserDescription(): string
    {
        return [
            'Comportement inapproprié envers les autres utilisateurs.',
            'Activités suspectes sur la plateforme.',
            'Harcèlement d\'autres membres.',
            'Tentatives d\'arnaque signalées.',
            'Utilisateur à surveiller.',
        ][array_rand([
            'Comportement inapproprié envers les autres utilisateurs.',
            'Activités suspectes sur la plateforme.',
            'Harcèlement d\'autres membres.',
            'Tentatives d\'arnaque signalées.',
            'Utilisateur à surveiller.',
        ])];
    }
} 