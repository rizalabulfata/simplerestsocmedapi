<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * An user can create a post.
     */
    public function test_user_can_create_a_post()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a post
        $post = Post::factory()->create([
            'user_id' => $user->id
        ]);

        // Assert that the post was created
        $this->assertDatabaseHas(Post::class, [
            'user_id' => $user->id,
            'title' => $post->title,
            'content' => $post->content
        ]);

        // Asset the post is related to the user
        $this->assertEquals($user->id, $post->user->id);
    }

    /**
     * An user can update a post.
     */
    public function test_user_can_update_a_post()
    {
        // Create a user and a post
        $user = User::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Original Title',
        ]);

        // Update the post
        $post->update([
            'title' => 'Updated Title',
        ]);

        // Assert that the post has been updated in the database
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    /**
     * An user can delete a post.
     */
    public function test_user_can_delete_a_post()
    {
        // Create a user and a post
        $user = User::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'My Post',
        ]);

        // Delete the post
        $post->delete();

        // Assert that the post no longer exists in the database
        $this->assertDatabaseMissing(Post::class, [
            'id' => $post->id,
        ]);
    }

    /**
     * An user can retrieve their posts.
     */
    public function test_user_can_retrieve_their_posts()
    {
        // Create a user
        $user = User::factory()->create();

        // Create two posts for the user
        Post::create([
            'user_id' => $user->id,
            'title' => 'Post 1',
            'caption' => 'Caption for Post 1',
        ]);
        Post::create([
            'user_id' => $user->id,
            'title' => 'Post 2',
            'caption' => 'Caption for Post 2',
        ]);

        // Retrieve the user's posts
        $posts = $user->posts;

        // Assert that the user has two posts
        $this->assertCount(2, $posts);
        $this->assertEquals('Post 1', $posts[0]->title);
        $this->assertEquals('Post 2', $posts[1]->title);
    }

    /**
     * A post can have images.
     */
    public function test_post_can_have_images()
    {
        // Create a post
        $post = Post::factory()->create();

        // Create two images for the post
        $post->images()->createMany([
            ['image_url' => 'image1.jpg'],
            ['image_url' => 'image2.jpg'],
        ]);

        // Retrieve the images for the post
        $images = $post->images;

        // Assert that the post has two images
        $this->assertCount(2, $images);
        $this->assertEquals('image1.jpg', $images[0]->image_url);
        $this->assertEquals('image2.jpg', $images[1]->image_url);
    }

    /**
     * A post can have likes.
     */
    public function test_post_can_have_likes()
    {
        // Create a post
        $post = Post::factory()->create();

        // Create two likes for the post
        $post->likes()->createMany([
            ['user_id' => User::factory()->create()->id],
            ['user_id' => User::factory()->create()->id],
        ]);

        // Retrieve the likes for the post
        $likes = $post->likes;

        // Assert that the post has two likes
        $this->assertCount(2, $likes);
    }

    /**
     * A post can have comments.
     */
    public function test_post_can_have_comments()
    {
        // Create a post
        $post = Post::factory()->create();

        // Create two comments for the post
        $post->comments()->createMany([
            ['user_id' => User::factory()->create()->id, 'content' => 'Comment 1'],
            ['user_id' => User::factory()->create()->id, 'content' => 'Comment 2'],
        ]);

        // Retrieve the comments for the post
        $comments = $post->comments;

        // Assert that the post has two comments
        $this->assertCount(2, $comments);
        $this->assertEquals('Comment 1', $comments[0]->content);
        $this->assertEquals('Comment 2', $comments[1]->content);
    }
}
