<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentTest extends BaseTest
{
    public function test_user_can_add_comment_to_post()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a post
        $post = Post::factory()->create();

        // Create a comment for the post by the user
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'This is a comment',
        ]);

        // Assert that the comment exists in the database
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'This is a comment',
        ]);

        // Assert that the comment is correctly linked to the user and post
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);
    }

    /**
     * Test that a user can update a comment
     */
    public function test_user_can_update_comment()
    {
        // Create a user, post and comment
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'This is a comment',
        ]);

        // Update the comment
        $comment->update([
            'content' => 'This is an updated comment',
        ]);

        // Assert that the comment has been updated in the database
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'This is an updated comment',
        ]);
    }

    /**
     * Test that a user can delete a comment
     */
    public function test_user_delete_comment()
    {
        // Create a user, post and comment
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'This is a comment',
        ]);

        // Delete the comment
        $comment->delete();

        // Assert that the comment has been deleted from the database
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    /**
     * Test that a post can retrieve its comments
     */
    public function test_post_can_retrieve_its_comments()
    {
        // Create a post
        $post = Post::factory()->create();

        // Create two users who comment on the post
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Add comments to the post
        Comment::create([
            'post_id' => $post->id,
            'user_id' => $user1->id,
            'content' => 'Comment by User 1.',
        ]);
        Comment::create([
            'post_id' => $post->id,
            'user_id' => $user2->id,
            'content' => 'Comment by User 2.',
        ]);

        // Retrieve the post's comments
        $comments = $post->comments;

        // Assert that the post has two comments
        $this->assertCount(2, $comments);
        $this->assertEquals('Comment by User 1.', $comments[0]->content);
        $this->assertEquals('Comment by User 2.', $comments[1]->content);
    }

    /**
     * Test that a user can retrieve their comments
     */
    public function test_user_can_retrieve_their_comments()
    {
        // Create a user
        $user = User::factory()->create();

        // Create two posts
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();

        // Add comments to both posts by the user
        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $user->id,
            'content' => 'Comment on Post 1.',
        ]);
        Comment::create([
            'post_id' => $post2->id,
            'user_id' => $user->id,
            'content' => 'Comment on Post 2.',
        ]);

        // Retrieve the user's comments
        $comments = $user->comments;

        // Assert that the user has two comments
        $this->assertCount(2, $comments);
        $this->assertTrue($comments->contains('content', 'Comment on Post 1.'));
        $this->assertTrue($comments->contains('content', 'Comment on Post 2.'));
    }
}
