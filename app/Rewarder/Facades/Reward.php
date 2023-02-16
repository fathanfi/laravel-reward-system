<?php

namespace App\Rewarder\Facades;

use App\Enums\RewardsTypeEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method nextAvailableRewards(Collection $rewards)
 * @method getLockedRewards(Collection $rewards)
 * @method firstRewardByType(Collection $locked, RewardsTypeEnum $type)
 * @method getRewardsName($unlockedRewards)
 */
class Reward extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reward_support';
    }
}
