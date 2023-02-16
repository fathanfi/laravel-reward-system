<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserReward extends Pivot
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
