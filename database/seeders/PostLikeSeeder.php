<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\PostLike;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostLikeSeeder extends Seeder
{
    public function run()
    {
        // Fetch all posts and users
        $posts = Post::all();
        $userId = rand(1, 10);
        // Ensure there are posts and users to create likes
        if ($posts->isEmpty()) {
            return;
        }

        $likes = [
            'user_id' => $userId,
        ];

        // Generate likes
        foreach ($posts as $post) {
            $likes[] = [
                'post_id' => $post->id,
            ];
            // Insert the likes into the post_like table
            DB::table('post_like')->insert($likes);
        }
    }
}
