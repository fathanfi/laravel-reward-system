<?php

namespace Tests\Feature\Models;

use App\Rewarder\Rewards\FiftyLessonsWatched;
use App\Rewarder\Rewards\FirstCommentWritten;
use App\Rewarder\Rewards\FirstLessonWatched;
use App\Rewarder\Rewards\FiveCommentsWritten;
use App\Rewarder\Rewards\FiveLessonsWatched;
use App\Rewarder\Rewards\TenCommentsWritten;
use App\Rewarder\Rewards\TenLessonsWatched;
use App\Rewarder\Rewards\ThreeCommentsWritten;
use App\Rewarder\Rewards\TwentyCommentsWritten;
use App\Rewarder\Rewards\TwentyFiveLessonsWatched;
use App\Events\RewardUnlocked;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RewardTestextends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_reward_is_earned_when_user_writes_1_comment()
    {
        $mehran = User::factory()->create();

        $john = User::factory()->create();

        $this->addComment($mehran);

        // Assert Mehran gets 1 reward...
        $this->assertCount(1, $mehran->rewards);

        $this->assertSame($mehran->rewards->first()->name, (new FirstCommentWritten)->name());

        // Assert John only has no reward...
        $this->assertCount(0, $john->rewards);
    }

    /** @test */
    public function two_rewards_is_earned_when_user_writes_3_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 3);

        $this->assertCount(2, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new ThreeCommentsWritten)->name()));
    }

    /** @test */
    public function three_rewards_is_earned_when_user_writes_5_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 5);

        $this->assertCount(3, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new FiveCommentsWritten)->name()));
    }

    /** @test */
    public function four_rewards_is_earned_when_user_writes_10_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 10);

        $this->assertCount(4, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new TenCommentsWritten)->name()));
    }

    /** @test */
    public function five_rewards_is_earned_when_user_writes_20_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 20);

        $this->assertCount(5, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new TwentyCommentsWritten)->name()));
    }

    /** @test */
    public function an_reward_is_earned_when_user_watches_1_lesson()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran);

        $this->assertCount(1, $mehran->rewards);

        $this->assertSame($mehran->rewards->first()->name, (new FirstLessonWatched)->name());
    }

    /** @test */
    public function two_rewards_is_earned_when_user_watches_5_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 5);

        $this->assertCount(2, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new FiveLessonsWatched)->name()));
    }

    /** @test */
    public function three_rewards_is_earned_when_user_watches_10_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 10);

        $this->assertCount(3, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new TenLessonsWatched)->name()));
    }

    /** @test */
    public function four_rewards_is_earned_when_user_watches_25_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 25);

        $this->assertCount(4, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new TwentyFiveLessonsWatched)->name()));
    }

    /** @test */
    public function five_rewards_is_earned_when_user_watches_50_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 50);

        $this->assertCount(5, $mehran->rewards);

        $this->assertTrue($mehran->rewards->contains('name', (new FiftyLessonsWatched)->name()));
    }

    /** @test */
    public function it_dispatches_an_event_when_an_reward_unlocked()
    {
        Event::fake(RewardUnlocked::class);

        $mehran = User::factory()->create();

        $this->addComment($mehran);

        Event::assertDispatched(RewardUnlocked::class, function ($event) {
            return $event->reward_name == (new FirstCommentWritten)->name();
        });
    }
}
