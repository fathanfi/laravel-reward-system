<?php

namespace App\Http\Controllers;

use App\Rewarder\Facades\Reward;
use App\Rewarder\Facades\Badge;
use App\Models\Badge as BadgeModel;
use App\Models\User;

class RewardsController extends Controller
{
    public function __invoke(User $user)
    {
        $rewards = $user->rewards;

        $nextRewards = Reward::nextAvailableRewards($rewards);

        $currentBadge = $this->getCurrentBadge($user);

        $nextBadge = Badge::nextBadge($currentBadge);

        return response()->json([
            'unlocked_rewards' => Reward::getRewardsName($rewards),
            'next_available_rewards' => Reward::getRewardsName($nextRewards),
            'current_badge' => $currentBadge->name ?? null,
            'next_badge' => $nextBadge->name ?? null,
            'remaining_to_unlock_next_badge' => Badge::remainingToUnlockNextBadge($rewards, $nextBadge),
        ]);
    }

    protected function getCurrentBadge(User $user): ?BadgeModel
    {
        $lockedBadges = Badge::lockedBadges($user);

        return $lockedBadges->last();
    }
}
