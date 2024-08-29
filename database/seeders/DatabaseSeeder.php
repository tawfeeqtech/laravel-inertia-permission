<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        $this->call(RolePermissionSeeder::class);
        $this->call(AdminSeeder::class);

        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        // $this->call(PostLikeSeeder::class);

        $this->call(CategoryPostSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(UserSeeder::class);
    }
}
