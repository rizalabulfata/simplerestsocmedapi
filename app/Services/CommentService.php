<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\ModelManagementService;

class CommentService extends ModelManagementService
{
    public function __construct(Comment $model = new Comment())
    {
        parent::__construct($model);
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
        $postService = new PostService();
        $post = $postService->getData($postId);

        $user->comments()->withTimestamps()->attach($post->id, ['content' => $comment]);
        $comment = $user->comments()->where('post_id', $post->id)->firstOrFail();

        return $comment;
    }

    /**
     * Uncomment a post.
     * 
     * @param User $user
     * @param int $commentId
     */
    public function uncomment(int $postId, int $commentId)
    {
        $post = (new PostService())->getData($postId);
        $post->comments()->where('id', $commentId)->delete();

        return $post;
    }

    /**c
     * Get the comments of the specified post.
     * 
     * @param int $postId
     */
    public function getComments(int $postId)
    {
        $post = (new PostService())->getData($postId);
        $comments = $post->comments;

        return $comments;
    }
}
