<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Services\ModelManagementService;

class PostService extends ModelManagementService
{
    public function __construct(Post $model = new Post())
    {
        parent::__construct($model);
    }

    /**
     * Get the post by author.
     * 
     * @param User $author
     */
    public function getPostByAuthor(User $author)
    {
        return $author->posts()->get();
    }

    /**
     * Get the post by author id.
     * 
     * @param int $authorId
     */
    public function getPostByAuthorId(int $authorId)
    {
        $userService = new UserService();
        return $userService->getData($authorId)?->posts()->get();
    }

    /**
     * Like a post.
     * 
     * @param User $user
     * @param int $postId
     */
    public function like(User $user, int $postId)
    {
        $post = $this->getData($postId);
        $user->likes()->withTimestamps()->attach($post->id);
        $like = $user->likes()->where('post_id', $post->id)->firstOrFail();

        return $like;
    }

    /**
     * Get the liked posts.
     * 
     * @param int $postId
     */
    public function likedPosts(int $postId)
    {
        $post = $this->getData($postId);
        return $post->likes()->get();
    }

    public function likedPostsByUser(User $user)
    {
        return $user->likes()->get();
    }

    /**
     * Unlike a post.
     * 
     * @param User $user
     * @param int $postId
     */
    public function unlike(User $user, int $postId)
    {
        $post = $this->getData($postId);
        $like = $user->likes()->withTimestamps()->detach($post->id);

        return $like;
    }

    /**
     * Comment a post.
     * 
     * @param User $user
     * @param int $postId
     * @param string $comment
     */
    public function comment(User $user, int $postId, string $comment)
    {
        $post = $this->getData($postId);
        $user->comments()->withTimestamps()->attach($post->id, ['comment' => $comment]);
        $comment = $user->comments()->where('post_id', $post->id)->firstOrFail();

        return $comment;
    }

    /**
     * Uncomment a post.
     * 
     * @param User $user
     * @param int $postId
     */
    public function uncomment(User $user, int $postId)
    {
        $post = $this->getData($postId);
        $comment = $user->comments()->detach($post->id);

        return $comment;
    }
}
