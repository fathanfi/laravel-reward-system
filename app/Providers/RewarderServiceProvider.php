<?php

namespace App\Providers;

use App\Rewarder\Rewards\FiftyLessonsWatched;
use App\Rewarder\Rewards\FirstCommentWritten;
use App\Rewarder\Rewards\FirstLessonWatched;
use App\Rewarder\Rewards\FiveCommentsWritten;
use App\Rewarder\Rewards\FiveLessonsWatched;
use App\Rewarder\Rewards\TenCommentsWritten;
use App\Rewarder\Rewards\TenLessonsWatched;
use App\Rewarder\Rewards\ThreeCommentsWritten;
use App\Rewarder\Rewards\TwentyCommentsWritten;
use App\Rewarder\Rewards\TwentyFiveLessonsWatched;
use App\Rewarder\Badges\AdvancedBadge;
use App\Rewarder\Badges\BeginnerBadge;
use App\Rewarder\Badges\IntermediateBadge;
use App\Rewarder\Badges\MasterBadge;
use App\Rewarder\Support\RewardSupport;
use App\Rewarder\Support\BadgeSupport;
use Illuminate\Support\ServiceProvider;

class RewarderServiceProvider extends ServiceProvider
{
    protected $rewards = [
        FirstCommentWritten::class,
        ThreeCommentsWritten::class,
        FiveCommentsWritten::class,
        TenCommentsWritten::class,
        TwentyCommentsWritten::class,
        FirstLessonWatched::class,
        FiveLessonsWatched::class,
        TenLessonsWatched::class,
        TwentyFiveLessonsWatched::class,
        FiftyLessonsWatched::class,
    ];

    protected $badges = [
        BeginnerBadge::class,
        IntermediateBadge::class,
        AdvancedBadge::class,
        MasterBadge::class,
    ];

    public function register()
    {
        $this->app->singleton('rewards', function () {
            return collect($this->rewards)->map(function ($reward) {
                return new $reward;
            });
        });

        $this->app->singleton('badges', function () {
            return collect($this->badges)->map(function ($badge) {
                return new $badge;
            });
        });

        $this->app->bind('reward_support', function () {
            return new RewardSupport;
        });

        $this->app->bind('badge_support', function () {
            return new BadgeSupport;
        });
    }
}
