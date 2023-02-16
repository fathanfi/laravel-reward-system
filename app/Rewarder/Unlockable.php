<?php

namespace App\Rewarder;

trait Unlockable
{
    /**
     * Unlock the new rewards for the user.
     */
    public function syncRewards()
    {
        $rewards = app('rewards')
            ->filter->qualifier($this)
            ->map->modelKey();

        $this->rewards()->sync($rewards);
    }

    /**
     * Unlock the new badges for the user.
     */
    public function syncBadges()
    {
        $badges = app('badges')
            ->filter->qualifier($this)
            ->map->modelKey();

        $this->badges()->sync($badges);
    }
}
