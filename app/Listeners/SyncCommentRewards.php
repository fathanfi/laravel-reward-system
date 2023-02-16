<?php

namespace App\Listeners;

use App\Events\CommentWritten;

class SyncCommentRewards
{
    public function handle(CommentWritten $event)
    {
        $user = $event->comment->user;

        $user->syncRewards();

        $user->syncBadges();
    }
}
