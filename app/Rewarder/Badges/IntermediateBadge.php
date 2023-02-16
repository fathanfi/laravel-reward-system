<?php

namespace App\Rewarder\Badges;

use App\Models\User;

class IntermediateBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->rewards()->count() >= $this->requiredRewards();
    }

    public function name(): string
    {
        return 'Intermediate';
    }

    public function order(): int
    {
        return 1;
    }

    public function requiredRewards(): int
    {
        return 4;
    }
}

