<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'follower_id' => User::inRandomOrder()->first()->id ?? UserFactory::new()->create()->id,
            'followed_id' => User::inRandomOrder()->first()->id ?? UserFactory::new()->create()->id
        ];
    }
}
