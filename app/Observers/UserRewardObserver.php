<?php

namespace App\Observers;

use App\Events\RewardUnlocked;
use App\Models\UserReward;

class UserRewardObserver
{
    public function created(UserReward $userReward)
    {
        event(new RewardUnlocked($userReward->user, $userReward->reward->name));
    }
}
