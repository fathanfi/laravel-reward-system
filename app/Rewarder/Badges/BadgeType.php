<?php

namespace App\Rewarder\Badges;

use App\Models\Reward;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class BadgeType
{
    /**
     * Reward's related model record
     * @var Reward
     */
    protected Model $model;

    public function __construct()
    {
        $this->model = Badge::firstOrCreate([
            'name' => $this->name(),
            'order_column' => $this->order(),
            'required_rewards' => $this->requiredRewards(),
        ]);
    }

    /**
     * Qualify if the user can unlock the badge.
     *
     * @param User $user
     * @return bool
     */
    abstract public function qualifier(User $user): bool;

    /**
     * Get the human-readable badge name.
     *
     * @return string
     */
    abstract public function name(): string;

    /**
     * Get the badge order number.
     *
     * @return int
     */
    abstract public function order(): int;

    /**
     * Get the required rewards to unlock the badge.
     *
     * @return int
     */
    abstract public function requiredRewards(): int;

    /**
     * Get the badge model.
     *
     * @return Badge
     */
    public function getModel(): Badge
    {
        return $this->model;
    }

    /**
     * Get the badge model ID.
     *
     * @return mixed
     */
    public function modelKey()
    {
        return $this->model->getKey();
    }
}
