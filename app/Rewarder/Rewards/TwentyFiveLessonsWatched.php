<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\User;

class TwentyFiveLessonsWatched extends RewardType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 25;
    }

    public function name(): string
    {
        return '25 Lessons Watched';
    }

    public function type(): RewardsTypeEnum
    {
        return RewardsTypeEnum::LESSON();
    }

    public function order(): int
    {
        return 8;
    }
}

