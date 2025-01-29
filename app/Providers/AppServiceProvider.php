<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register Services
        $this->app->singleton('App\Services\Auth\AuthService');
        $this->app->singleton('App\Services\User\UserService');
        $this->app->singleton('App\Services\Ad\AdService');
        $this->app->singleton('App\Services\Exchange\ExchangeService');
        $this->app->singleton('App\Services\Review\ReviewService');
        $this->app->singleton('App\Services\Badge\BadgeService');
        $this->app->singleton('App\Services\Report\ReportService');
        $this->app->singleton('App\Services\Dispute\DisputeService');
        $this->app->singleton('App\Services\Sponsor\SponsorService');
        $this->app->singleton('App\Services\Contest\ContestService');
    }

    public function boot(): void
    {
        // Boot services
    }
}
