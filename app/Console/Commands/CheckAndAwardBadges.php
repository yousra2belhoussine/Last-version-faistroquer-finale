<?php

namespace App\Console\Commands;

use App\Http\Controllers\BadgeController;
use App\Models\User;
use Illuminate\Console\Command;

class CheckAndAwardBadges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:check-and-award';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and award badges to users based on various criteria';

    /**
     * Execute the console command.
     */
    public function handle(BadgeController $badgeController)
    {
        $this->info('Starting badge check process...');

        // Check account age badges for all users
        $this->info('Checking account age badges...');
        $users = User::all();
        foreach ($users as $user) {
            $badgeController->checkAccountAgeBadges($user);
        }
        $this->info('Account age badges checked.');

        // Check top contributor badges (weekly and monthly)
        $this->info('Checking top contributor badges...');
        $badgeController->checkTopContributorBadges();
        $this->info('Top contributor badges checked.');

        // Check milestone badges for all users
        $this->info('Checking milestone badges...');
        foreach ($users as $user) {
            $badgeController->checkMilestoneBadges($user);
        }
        $this->info('Milestone badges checked.');

        // Clean up expired badges
        $this->info('Cleaning up expired badges...');
        $expiredBadges = Badge::where('expires_at', '<', now())->get();
        foreach ($expiredBadges as $badge) {
            // Notify user about expired badge
            $badge->user->notify(new BadgeExpired($badge));
            // Delete the badge
            $badge->delete();
        }
        $this->info('Expired badges cleaned up.');

        $this->info('Badge check process completed successfully.');
    }
} 