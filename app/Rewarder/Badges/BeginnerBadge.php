<?php

namespace App\Rewarder\Badges;

use App\Models\User;

class BeginnerBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->rewards()->count() >= $this->requiredRewards();
    }

    public function name(): string
    {
        return 'Beginner';
    }

    public function order(): int
    {
        return 0;
    }

    public function requiredRewards(): int
    {
        return 0;
    }
}

