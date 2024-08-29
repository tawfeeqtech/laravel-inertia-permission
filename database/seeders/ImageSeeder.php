<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ImageSeeder extends Seeder
{
    public function run()
    {
        Post::all()->each(function ($post) {
            Image::factory()->count(1)->create([
                'imageable_id' => $post->id,
                'imageable_type' => Post::class,
            ]);
        });
    }
}
