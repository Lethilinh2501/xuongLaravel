<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PostComment;
use App\Models\User;
use App\Models\Post;

class PostCommentFactory extends Factory
{
    protected $model = PostComment::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'post_id' => Post::inRandomOrder()->first()->id ?? Post::factory(),
            'comment' => $this->faker->paragraph(),
        ];
    }
}
