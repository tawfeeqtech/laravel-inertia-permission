<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraphs(3, true),
            'published_at' => $this->faker->boolean ? now() : null,
            'featured' => $this->faker->boolean(20), // 20% chance of being featured
            'user_id' => User::factory()->create()->id,
        ];
    }
}
