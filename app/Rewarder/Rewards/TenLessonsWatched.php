<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\User;

class TenLessonsWatched extends RewardType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 10;
    }

    public function name(): string
    {
        return '10 Lessons Watched';
    }

    public function type(): RewardsTypeEnum
    {
        return RewardsTypeEnum::LESSON();
    }

    public function order(): int
    {
        return 7;
    }
}

