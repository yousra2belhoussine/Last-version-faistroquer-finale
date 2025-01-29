<?php

namespace App\Console\Commands;

use App\Http\Controllers\BadgeController;
use App\Models\User;
use Illuminate\Console\Command;

class CheckBadges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and award badges to users';

    /**
     * Execute the console command.
     */
    public function handle(BadgeController $badgeController)
    {
        $this->info('Checking badges...');

        // Vérifier les badges d'ancienneté pour tous les utilisateurs
        User::chunk(100, function ($users) use ($badgeController) {
            foreach ($users as $user) {
                $badgeController->checkAccountAgeBadges($user);
                $badgeController->checkExchangeBadges($user);
            }
        });

        // Vérifier les badges de top déposeur
        $badgeController->checkTopPosterBadges();

        // Vérifier les badges de top troqueur
        $badgeController->checkTopTraderBadges();

        $this->info('Badge check completed!');
    }
} 