<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\User;

class FirstCommentWritten extends RewardType
{
    public function qualifier(User $user): bool
    {
        return $user->comments()->count() >= 1;
    }

    public function name(): string
    {
        return 'First Comment Written';
    }

    public function type(): RewardsTypeEnum
    {
        return RewardsTypeEnum::COMMENT();
    }

    public function order(): int
    {
        return 0;
    }
}

