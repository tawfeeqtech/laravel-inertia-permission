<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Post::create([
        //     'title' => 'First Post',
        //     'slug' => Str::slug('First Post'),
        //     'body' => 'This is the body of the first post.',
        //     'user_id' => User::first()->id,
        //     'published_at' => now(),
        // ]);

        Post::factory()->count(20)->create();
    }
}
