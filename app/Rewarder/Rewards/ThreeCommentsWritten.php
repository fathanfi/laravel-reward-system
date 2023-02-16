<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\User;

class ThreeCommentsWritten extends RewardType
{
    public function qualifier(User $user): bool
    {
        return $user->comments()->count() >= 3;
    }

    public function name(): string
    {
        return '3 Comments Written';
    }

    public function type(): RewardsTypeEnum
    {
        return RewardsTypeEnum::COMMENT();
    }

    public function order(): int
    {
        return 1;
    }
}

