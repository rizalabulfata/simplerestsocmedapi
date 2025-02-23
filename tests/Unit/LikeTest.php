<?php

namespace Tests\Unit;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class LikeTest extends TestCase
{
    /**
     * Test that a user can like a post
     */
    public function test_user_can_like_a_post()
    {
        // Create a user and a post
        $user = User::factory()->create();
        $post = Post::factory()->create();

        // Create a like for the post by the user
        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Assert that the like exists in the database
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Assert that the like is correctly linked to the user and post
        $this->assertEquals($user->id, $like->user_id);
        $this->assertEquals($post->id, $like->post_id);
    }

    /**
     * Test that a user can unlike a post
     */
    public function test_user_can_unlike_a_post()
    {
        // Create a user and a post
        $user = User::factory()->create();
        $post = Post::factory()->create();

        // Create a like for the post by the user
        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Delete the like
        $like->delete();

        // Assert that the like has been deleted from the database
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    /**
     * Test that a post can retrieve its likes
     */
    public function test_post_can_retrieve_likes()
    {
        // Create a post
        $post = Post::factory()->create();

        // Create two users who like the post
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create likes for the post
        Like::create(['user_id' => $user1->id, 'post_id' => $post->id]);
        Like::create(['user_id' => $user2->id, 'post_id' => $post->id]);

        // Retrieve the post's likes
        $likes = $post->likes;

        // Assert that the post has two likes
        $this->assertCount(2, $likes);
        $this->assertTrue($likes->contains('user_id', $user1->id));
        $this->assertTrue($likes->contains('user_id', $user2->id));
    }

    /**
     * Test that a user can retrieve their liked posts
     */
    public function a_user_can_retrieve_their_liked_posts()
    {
        // Create a user
        $user = User::factory()->create();

        // Create two posts
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();

        // Create likes for the user
        Like::create(['user_id' => $user->id, 'post_id' => $post1->id]);
        Like::create(['user_id' => $user->id, 'post_id' => $post2->id]);

        // Retrieve the user's likes
        $likes = $user->likes;

        // Assert that the user has two likes
        $this->assertCount(2, $likes);
        $this->assertTrue($likes->contains('post_id', $post1->id));
        $this->assertTrue($likes->contains('post_id', $post2->id));
    }
}
