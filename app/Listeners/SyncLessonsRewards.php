<?php

namespace App\Listeners;

use App\Events\LessonWatched;

class SyncLessonsRewards
{
    public function handle(LessonWatched $event)
    {
        $user = $event->user;

        $user->syncRewards();

        $user->syncBadges();
    }
}
