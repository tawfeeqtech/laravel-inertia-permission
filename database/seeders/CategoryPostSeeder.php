<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all posts
        $categories = Category::all();
        $posts = Post::all();

        // Ensure there are categories and posts
        if ($categories->isEmpty() || $posts->isEmpty()) {
            return;
        }

        // Assign categories to posts
        foreach ($posts as $post) {
            // Random number of categories for each post
            $categoryCount = rand(1, 5);
            $selectedCategories = $categories->random($categoryCount)->pluck('id');

            $categoryPosts = [];
            foreach ($selectedCategories as $categoryId) {
                $categoryPosts[] = [
                    'category_id' => $categoryId,
                    'post_id' => $post->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            // Insert the category_post entries
            DB::table('category_post')->insert($categoryPosts);
        }
    }
}
