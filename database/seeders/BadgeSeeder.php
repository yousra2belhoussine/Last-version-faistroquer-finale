<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('status', 'active')->get();

        foreach ($users as $user) {
            // Account age badges
            $accountAge = Carbon::parse($user->created_at)->diffInYears(now());
            
            if ($accountAge >= 1) {
                Badge::create([
                    'user_id' => $user->id,
                    'type' => 'account_age_1',
                    'name' => 'Un An de Membre',
                    'description' => 'Membre depuis plus d\'un an',
                    'awarded_at' => now()->subDays(rand(1, 30)),
                ]);
            }

            // Transaction milestone badges
            $transactionCount = $user->transactions()->where('status', 'completed')->count();
            
            if ($transactionCount >= 1) {
                Badge::create([
                    'user_id' => $user->id,
                    'type' => 'first_transaction',
                    'name' => 'Premier Échange',
                    'description' => 'A réalisé son premier échange',
                    'awarded_at' => now()->subDays(rand(1, 30)),
                ]);
            }
            
            if ($transactionCount >= 10) {
                Badge::create([
                    'user_id' => $user->id,
                    'type' => 'transactions_10',
                    'name' => 'Échangeur Pro',
                    'description' => 'A réalisé 10 échanges',
                    'awarded_at' => now()->subDays(rand(1, 30)),
                ]);
            }

            // Review badges
            $reviewCount = $user->receivedReviews()->count();
            $averageRating = $user->receivedReviews()->avg('rating');
            
            if ($reviewCount >= 10 && $averageRating >= 4.5) {
                Badge::create([
                    'user_id' => $user->id,
                    'type' => 'top_rated',
                    'name' => 'Très Bien Noté',
                    'description' => 'Maintient une note de 4.5+ avec plus de 10 avis',
                    'awarded_at' => now()->subDays(rand(1, 30)),
                ]);
            }

            // Ad badges
            $adCount = $user->ads()->count();
            
            if ($adCount >= 10) {
                Badge::create([
                    'user_id' => $user->id,
                    'type' => 'active_poster',
                    'name' => 'Annonceur Actif',
                    'description' => 'A publié plus de 10 annonces',
                    'awarded_at' => now()->subDays(rand(1, 30)),
                ]);
            }

            // Professional badges
            if ($user->type === 'professional' && $user->professional_validated_at) {
                Badge::create([
                    'user_id' => $user->id,
                    'type' => 'verified_professional',
                    'name' => 'Professionnel Vérifié',
                    'description' => 'Statut professionnel vérifié',
                    'awarded_at' => $user->professional_validated_at,
                ]);
            }

            // Top contributor badges (temporary)
            if ($transactionCount >= 5 && $adCount >= 5 && $averageRating >= 4) {
                Badge::create([
                    'user_id' => $user->id,
                    'type' => 'top_contributor',
                    'name' => 'Top Contributeur',
                    'description' => 'Membre actif et bien noté',
                    'awarded_at' => now()->subDays(rand(1, 7)),
                    'expires_at' => now()->addDays(30),
                ]);
            }
        }
    }
} 