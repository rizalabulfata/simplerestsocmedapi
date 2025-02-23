<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\PostImage;
use Tests\TestCase;

class PostImageTest extends TestCase
{
    /**
     * Test that a post image can be created
     */
    public function test_post_image_can_be_created()
    {
        // Create a post
        $post = Post::factory()->create();

        // Create a post image for the post
        $postImage = PostImage::create([
            'post_id' => $post->id,
            'image_url' => 'https://example.com/image.jpg',
        ]);

        // Assert that the post image exists in the database
        $this->assertDatabaseHas('post_images', [
            'id' => $postImage->id,
            'post_id' => $post->id,
            'image_url' => 'https://example.com/image.jpg',
        ]);

        // Assert that the post image is correctly linked to the post
        $this->assertEquals($post->id, $postImage->post_id);
    }

    /**
     * Test that a post image can be updated
     */
    public function test_post_image_can_be_updated()
    {
        // Create a post and a post image
        $post = Post::factory()->create();
        $postImage = PostImage::create([
            'post_id' => $post->id,
            'image_url' => 'https://example.com/old-image.jpg',
        ]);

        // Update the post image
        $postImage->update([
            'image_url' => 'https://example.com/new-image.jpg',
        ]);

        // Assert that the post image has been updated in the database
        $this->assertDatabaseHas('post_images', [
            'id' => $postImage->id,
            'image_url' => 'https://example.com/new-image.jpg',
        ]);
    }

    /**
     * Test that a post image can be deleted
     */
    public function test_post_image_can_be_deleted()
    {
        // Create a post and a post image
        $post = Post::factory()->create();
        $postImage = PostImage::create([
            'post_id' => $post->id,
            'image_url' => 'https://example.com/image.jpg',
        ]);

        // Delete the post image
        $postImage->delete();

        // Assert that the post image no longer exists in the database
        $this->assertDatabaseMissing('post_images', [
            'id' => $postImage->id,
        ]);
    }

    /**
     * Test that a post image belongs to a post
     */
    public function test_post_image_belongs_to_a_post()
    {
        // Create a post
        $post = Post::factory()->create();

        // Create a post image for the post
        $postImage = PostImage::create([
            'post_id' => $post->id,
            'image_url' => 'https://example.com/image.jpg',
        ]);

        // Assert that the post image belongs to the post
        $this->assertEquals($post->id, $postImage->post->id);
    }
}
