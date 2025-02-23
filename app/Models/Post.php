<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    /**
     * Get the user that owns the Post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all images for the Post
     */
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    /**
     * Get all likes for the Post
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get all comments for the Post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
