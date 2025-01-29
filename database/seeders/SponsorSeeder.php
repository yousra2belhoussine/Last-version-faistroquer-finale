<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\SponsorCampaign;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            [
                'name' => 'Eco-Troc',
                'description' => 'Entreprise spécialisée dans le recyclage et la réutilisation',
                'website' => 'https://www.eco-troc.fr',
                'contact_email' => 'contact@eco-troc.fr',
                'contact_phone' => '01 23 45 67 89',
            ],
            [
                'name' => 'GreenExchange',
                'description' => 'Promotion des échanges écologiques et durables',
                'website' => 'https://www.greenexchange.fr',
                'contact_email' => 'contact@greenexchange.fr',
                'contact_phone' => '01 34 56 78 90',
            ],
            [
                'name' => 'CirculEco',
                'description' => 'Expert en économie circulaire et collaborative',
                'website' => 'https://www.circuleco.fr',
                'contact_email' => 'contact@circuleco.fr',
                'contact_phone' => '01 45 67 89 01',
            ],
        ];

        foreach ($sponsors as $sponsorData) {
            $sponsor = Sponsor::create($sponsorData);

            // Create 2-4 campaigns for each sponsor
            $numCampaigns = rand(2, 4);
            for ($i = 0; $i < $numCampaigns; $i++) {
                $startDate = now()->addDays(rand(-30, 30));
                
                SponsorCampaign::create([
                    'sponsor_id' => $sponsor->id,
                    'name' => $this->getRandomCampaignName($sponsor->name),
                    'description' => $this->getRandomCampaignDescription(),
                    'type' => ['banner', 'featured', 'newsletter'][array_rand(['banner', 'featured', 'newsletter'])],
                    'budget' => rand(500, 5000),
                    'status' => ['draft', 'active', 'paused', 'completed'][array_rand(['draft', 'active', 'paused', 'completed'])],
                    'start_date' => $startDate,
                    'end_date' => $startDate->copy()->addDays(rand(15, 90)),
                    'target_audience' => $this->getRandomTargetAudience(),
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }

    /**
     * Get a random campaign name based on sponsor name.
     */
    private function getRandomCampaignName(string $sponsorName): string
    {
        $templates = [
            'Campagne {sponsor} - Printemps 2024',
            'Promotion {sponsor} - Été 2024',
            '{sponsor} - Spécial Rentrée',
            'Découvrez {sponsor}',
            'Offre Exclusive {sponsor}',
        ];

        $template = $templates[array_rand($templates)];
        return str_replace('{sponsor}', $sponsorName, $template);
    }

    /**
     * Get a random campaign description.
     */
    private function getRandomCampaignDescription(): string
    {
        return [
            'Campagne de promotion pour encourager les échanges responsables.',
            'Mise en avant de notre engagement pour l\'économie circulaire.',
            'Promotion de notre plateforme auprès des utilisateurs actifs.',
            'Campagne de sensibilisation au réemploi et à l\'échange.',
            'Programme de fidélisation pour les membres actifs.',
        ][array_rand([
            'Campagne de promotion pour encourager les échanges responsables.',
            'Mise en avant de notre engagement pour l\'économie circulaire.',
            'Promotion de notre plateforme auprès des utilisateurs actifs.',
            'Campagne de sensibilisation au réemploi et à l\'échange.',
            'Programme de fidélisation pour les membres actifs.',
        ])];
    }

    /**
     * Get random target audience settings.
     */
    private function getRandomTargetAudience(): array
    {
        return [
            'age_range' => ['18-25', '25-34', '35-44', '45-54', '55+'][array_rand(['18-25', '25-34', '35-44', '45-54', '55+'])],
            'regions' => ['Île-de-France', 'Auvergne-Rhône-Alpes', 'Provence-Alpes-Côte d\'Azur'],
            'interests' => ['écologie', 'économie circulaire', 'développement durable', 'réemploi'],
            'user_type' => ['all', 'particular', 'professional'][array_rand(['all', 'particular', 'professional'])],
        ];
    }
} 