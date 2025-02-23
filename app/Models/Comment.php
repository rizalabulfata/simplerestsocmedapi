<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    /**
     * Get the user that owns the Comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that owns the Comment
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get all likes for the Comment
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
