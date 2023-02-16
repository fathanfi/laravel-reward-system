<?php

namespace App\Rewarder\Badges;

use App\Models\User;

class MasterBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->rewards()->count() >= $this->requiredRewards();
    }

    public function name(): string
    {
        return 'Master';
    }

    public function order(): int
    {
        return 3;
    }

    public function requiredRewards(): int
    {
        return 10;
    }
}

