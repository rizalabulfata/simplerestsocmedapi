<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Database\Factories\PostFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create 5 users
        User::factory(5)->create();

        // create posts for each user
        User::all()->each(function ($user) {
            $total = fake()->numberBetween(1, 10);
            $user->posts()->saveMany(Post::factory($total)->make(['user_id' => $user->id]));
        });

        // create comments for each post
        Post::all()->each(function ($post) {
            $total = fake()->numberBetween(1, 10);
            $post->comments()->saveMany(Comment::factory($total)->make());
        });

        // create likes for each post
        Post::all()->each(function ($post) {
            $total = fake()->numberBetween(1, 10);
            $post->likes()->saveMany(Like::factory($total)->make());
        });

        // create images for each post
        Post::all()->each(function ($post) {
            $total = fake()->numberBetween(1, 10);
            $post->images()->saveMany(PostImage::factory($total)->make(['post_id' => $post->id]));
        });

        // create followers also following for each user
        User::all()->each(function ($user) {
            $totalUser = User::count() - 1;
            $total = fake()->numberBetween(1, $totalUser);
            $users = User::where('id', '!=', $user->id)->inRandomOrder()->limit($total)->get();

            $user->followers()->attach($users->pluck('id'));
        });
    }
}
