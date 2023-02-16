<?php

namespace Tests\Feature;

use App\Rewarder\Rewards\FiftyLessonsWatched;
use App\Rewarder\Rewards\FirstCommentWritten;
use App\Rewarder\Rewards\FirstLessonWatched;
use App\Rewarder\Rewards\FiveCommentsWritten;
use App\Rewarder\Rewards\FiveLessonsWatched;
use App\Rewarder\Rewards\TenLessonsWatched;
use App\Rewarder\Rewards\ThreeCommentsWritten;
use App\Rewarder\Rewards\TwentyCommentsWritten;
use App\Rewarder\Badges\AdvancedBadge;
use App\Rewarder\Badges\IntermediateBadge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RewardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_retrieve_user_rewards_status()
    {
        // Given we have a user with 4 rewards and 2 badges...
        $mehran = User::factory()->create();

        $this->addComment($mehran, 3);

        $this->watchLesson($mehran, 5);

        $res = $this->get(route('users.rewards.index', $mehran))
            ->assertOk();

        // Assert all the properties get filled correctly...
        $res->assertJson([
            'unlocked_rewards' => [
                (new FirstCommentWritten)->name(),
                (new ThreeCommentsWritten)->name(),
                (new FirstLessonWatched)->name(),
                (new FiveLessonsWatched)->name(),
            ]
        ]);

        $res->assertJson([
            'next_available_rewards' => [
                (new FiveCommentsWritten)->name(),
                (new TenLessonsWatched)->name(),
            ]
        ]);

        $remainingToNextBadge = (new AdvancedBadge)->requiredRewards() - $mehran->rewards->count();

        $res->assertJson([
            'current_badge' => (new IntermediateBadge)->name(),
            'next_badge' => (new AdvancedBadge)->name(),
            'remaining_to_unlock_next_badge' => $remainingToNextBadge,
        ]);
    }

    /** @test */
    public function unlocked_rewards_returns_empty_array_if_no_reward_unlocked()
    {
        $mehran = User::factory()->create();

        $this->get(route('users.rewards.index', $mehran))
            ->assertOk()
            ->assertJson([
                'unlocked_rewards' => [],
                'next_available_rewards' => [
                    (new FirstCommentWritten)->name(),
                    (new FirstLessonWatched)->name(),
                ]
            ]);
    }

    /** @test */
    public function next_available_rewards_returns_empty_array_if_all_rewards_unlocked()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 20);

        $this->watchLesson($mehran, 50);

        // Also assert the next badge is null as well as remaining...
        $this->get(route('users.rewards.index', $mehran))
            ->assertOk()
            ->assertJsonFragment([
                'next_available_rewards' => [],
                'next_badge' => null,
                'remaining_to_unlock_next_badge' => 0
            ]);
    }

    /** @test */
    public function next_available_rewards_can_have_no_locked_comment_reward()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 20);

        $this->watchLesson($mehran, 25);

        $this->get(route('users.rewards.index', $mehran))
            ->assertOk()
            ->assertJson([
                'next_available_rewards' => [
                    (new FiftyLessonsWatched)->name(),
                ]
            ]);
    }

    /** @test */
    public function next_available_rewards_can_have_no_locked_lesson_reward()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 10);

        $this->watchLesson($mehran, 50);

        $this->get(route('users.rewards.index', $mehran))
            ->assertOk()
            ->assertJson([
                'next_available_rewards' => [
                    (new TwentyCommentsWritten)->name(),
                ]
            ]);
    }
}
