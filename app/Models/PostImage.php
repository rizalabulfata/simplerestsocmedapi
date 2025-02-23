<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class PostImage extends Model
{
    /** @use HasFactory<\Database\Factories\PostImageFactory> */
    use HasFactory;

    /**
     * Get the post that owns the Image
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
