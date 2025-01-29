<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('status', 'active')->get();

        // Create past contests (last 3 months)
        for ($i = 1; $i <= 12; $i++) {
            $startDate = now()->subMonths(3)->addWeeks($i);
            $endDate = $startDate->copy()->addDays(7);
            
            $contest = Contest::create([
                'name' => $this->getRandomContestName($startDate),
                'description' => $this->getRandomContestDescription(),
                'rules' => $this->getContestRules(),
                'prize_description' => $this->getRandomPrize(),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $endDate->isPast() ? 'completed' : 'active',
                'created_at' => $startDate->subDays(rand(1, 7)),
            ]);

            if ($contest->status === 'completed') {
                // Select winner based on activity during contest period
                $winner = $users->random();
                $contest->update([
                    'winner_id' => $winner->id,
                    'winner_selected_at' => $endDate->addDays(1),
                ]);
            }
        }

        // Create future contests (next month)
        for ($i = 1; $i <= 4; $i++) {
            $startDate = now()->addWeeks($i);
            $endDate = $startDate->copy()->addDays(7);
            
            Contest::create([
                'name' => $this->getRandomContestName($startDate),
                'description' => $this->getRandomContestDescription(),
                'rules' => $this->getContestRules(),
                'prize_description' => $this->getRandomPrize(),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'scheduled',
                'created_at' => now()->subDays(rand(1, 7)),
            ]);
        }
    }

    /**
     * Get a random contest name based on date.
     */
    private function getRandomContestName(Carbon $date): string
    {
        $templates = [
            'Concours de la Semaine - {date}',
            'Challenge Échange - {date}',
            'Troqueur de la Semaine - {date}',
            'Défi Écologique - {date}',
            'Star du Troc - {date}',
        ];

        $template = $templates[array_rand($templates)];
        return str_replace('{date}', $date->format('d/m/Y'), $template);
    }

    /**
     * Get a random contest description.
     */
    private function getRandomContestDescription(): string
    {
        return [
            'Participez à notre concours hebdomadaire et gagnez des récompenses exclusives !',
            'Cette semaine, nous récompensons les échanges les plus écologiques.',
            'Montrez votre créativité dans vos échanges et gagnez des prix.',
            'Concours spécial pour promouvoir les échanges responsables.',
            'Devenez le meilleur troqueur de la semaine !',
        ][array_rand([
            'Participez à notre concours hebdomadaire et gagnez des récompenses exclusives !',
            'Cette semaine, nous récompensons les échanges les plus écologiques.',
            'Montrez votre créativité dans vos échanges et gagnez des prix.',
            'Concours spécial pour promouvoir les échanges responsables.',
            'Devenez le meilleur troqueur de la semaine !',
        ])];
    }

    /**
     * Get contest rules.
     */
    private function getContestRules(): array
    {
        return [
            'Être un membre actif de la plateforme',
            'Avoir réalisé au moins un échange pendant la période du concours',
            'Avoir une note moyenne supérieure à 4 étoiles',
            'Respecter les conditions générales d\'utilisation',
            'Les échanges doivent être conformes à notre charte éthique',
        ];
    }

    /**
     * Get a random prize description.
     */
    private function getRandomPrize(): string
    {
        return [
            'Un bon d\'achat de 50€ chez nos partenaires éco-responsables',
            'Une mise en avant de votre profil pendant une semaine',
            'Un badge exclusif "Super Troqueur" sur votre profil',
            'Un accès premium gratuit pendant 3 mois',
            'Un lot de produits écologiques d\'une valeur de 100€',
        ][array_rand([
            'Un bon d\'achat de 50€ chez nos partenaires éco-responsables',
            'Une mise en avant de votre profil pendant une semaine',
            'Un badge exclusif "Super Troqueur" sur votre profil',
            'Un accès premium gratuit pendant 3 mois',
            'Un lot de produits écologiques d\'une valeur de 100€',
        ])];
    }
} 