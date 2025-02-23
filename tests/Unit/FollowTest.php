<?php

namespace Tests\Unit;

use App\Models\Follow;
use App\Models\User;

class FollowTest extends BaseTest
{
    /**
     * An user can follow another user.
     */
    public function test_user_can_follow_another_user()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        Follow::create([
            'follower_id' => $user->id,
            'followed_id' => $anotherUser->id
        ]);

        $this->assertDatabaseHas(Follow::class, [
            'follower_id' => $user->id,
            'followed_id' => $anotherUser->id
        ]);
    }

    /**
     * An user can unfollow another user.
     */
    public function test_user_can_unfollow_another_user()
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Follow user2 as user1
        $follow = Follow::create([
            'follower_id' => $user1->id,
            'followed_id' => $user2->id,
        ]);

        // Unfollow user2
        $follow->delete();

        // Assert that the follow relationship no longer exists
        $this->assertDatabaseMissing(Follow::class, [
            'follower_id' => $user1->id,
            'followed_id' => $user2->id,
        ]);
    }

    /**
     * An user can retrieve the users they are following.
     */
    public function test_user_can_retrieve_the_followers()
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Follow user2 as user1
        Follow::create([
            'follower_id' => $user1->id,
            'followed_id' => $user2->id,
        ]);

        // Retrieve the followers of user2
        $followers = $user2->followers;

        // Assert that user1 is a follower of user2
        $this->assertTrue($followers->contains($user1));
    }

    /**
     * An user can retrieve the users they are following.
     */
    public function test_user_can_retrieve_the_following()
    {
        // Create three users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        // User1 follows User2 and User3
        Follow::create(['follower_id' => $user1->id, 'followed_id' => $user2->id]);
        Follow::create(['follower_id' => $user1->id, 'followed_id' => $user3->id]);

        // Retrieve users that User1 is following
        $following = $user1->following;

        // Assert that User1 is following two users
        $this->assertCount(2, $following);
        $this->assertTrue($following->contains('id', $user2->id));
        $this->assertTrue($following->contains('id', $user3->id));
    }
}
