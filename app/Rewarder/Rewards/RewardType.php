<?php

namespace App\Rewarder\Rewards;

use App\Enums\RewardsTypeEnum;
use App\Models\Reward;
use App\Models\User;

abstract class RewardType
{
    /**
     * Reward's related model record
     * @var Reward
     */
    protected Reward $model;

    public function __construct()
    {
        $this->model = Reward::firstOrCreate([
            'name' => $this->name(),
            'type' => $this->type(),
            'order_column' => $this->order(),
        ]);
    }

    /**
     * Qualify if the user can unlock the reward.
     *
     * @param User $user
     * @return bool
     */
    abstract public function qualifier(User $user): bool;

    /**
     * Get the human-readable reward name.
     *
     * @return string
     */
    abstract public function name(): string;

    /**
     * Get the reward type.
     *
     * @return RewardsTypeEnum
     */
    abstract public function type(): RewardsTypeEnum;

    /**
     * Get the reward order number.
     *
     * @return int
     */
    abstract public function order(): int;

    /**
     * Get the reward model.
     *
     * @return Reward
     */
    public function getModel(): Reward
    {
        return $this->model;
    }

    /**
     * Get the reward model ID.
     *
     * @return mixed
     */
    public function modelKey()
    {
        return $this->model->getKey();
    }
}
