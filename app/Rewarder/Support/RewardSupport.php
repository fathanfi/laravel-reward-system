<?php

namespace App\Rewarder\Support;

use App\Enums\RewardsTypeEnum;
use App\Models\Reward as RewardModel;
use Illuminate\Support\Collection;

class RewardSupport
{
    public function nextAvailableRewards(Collection $rewards): Collection
    {
        $locked = $this->getLockedRewards($rewards);

        $collect = collect([
            $this->firstRewardByType($locked, RewardsTypeEnum::LESSON()),
            $this->firstRewardByType($locked, RewardsTypeEnum::COMMENT()),
        ]);

        return $collect->sortBy('order_column')->filter();
    }

    public function getLockedRewards(Collection $rewards): Collection
    {
        return app('rewards')
            ->filter(function ($reward) use ($rewards) {
                return $rewards
                    ->doesntContain('name', $reward->name());
            })
            ->map->getModel();
    }

    public function firstRewardByType(Collection $locked, RewardsTypeEnum $type): ?RewardModel
    {
        return $locked->first(function ($reward) use ($type) {
            return $reward->type->isEqual($type);
        });
    }

    public function getRewardsName($unlockedRewards): array
    {
        return $unlockedRewards->pluck('name')->toArray();
    }
}
