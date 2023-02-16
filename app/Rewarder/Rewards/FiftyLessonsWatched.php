<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\User;

class FiftyLessonsWatched extends RewardType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 50;
    }

    public function name(): string
    {
        return '50 Lessons Watched';
    }

    public function type(): RewardsTypeEnum
    {
        return RewardsTypeEnum::LESSON();
    }

    public function order(): int
    {
        return 9;
    }
}

