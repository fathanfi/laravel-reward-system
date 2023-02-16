<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserReward;
use App\Models\UserBadge;
use App\Observers\UserRewardObserver;
use App\Observers\UserBadgeObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        UserReward::observe(UserRewardObserver::class);
        UserBadge::observe(UserBadgeObserver::class);
        User::observe(UserObserver::class);
    }
}
