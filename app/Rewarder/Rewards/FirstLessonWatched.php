<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\User;

class FirstLessonWatched extends RewardType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 1;
    }

    public function name(): string
    {
        return 'First Lesson Watched';
    }

    public function type(): RewardsTypeEnum
    {
        return RewardsTypeEnum::LESSON();
    }

    public function order(): int
    {
        return 5;
    }
}

