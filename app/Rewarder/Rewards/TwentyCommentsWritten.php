<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\User;

class TwentyCommentsWritten extends RewardType
{
    public function qualifier(User $user): bool
    {
        return $user->comments()->count() >= 20;
    }

    public function name(): string
    {
        return '20 Comments Written';
    }

    public function type(): RewardsTypeEnum
    {
        return RewardsTypeEnum::COMMENT();
    }

    public function order(): int
    {
        return 4;
    }
}

