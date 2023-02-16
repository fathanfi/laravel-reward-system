<?php

namespace App\Rewarder\Badges;

use App\Models\User;

class AdvancedBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->rewards()->count() >= $this->requiredRewards();
    }

    public function name(): string
    {
        return 'Advanced';
    }

    public function order(): int
    {
        return 2;
    }

    public function requiredRewards(): int
    {
        return 8;
    }
}

