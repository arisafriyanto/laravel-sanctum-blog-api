<?php

namespace Database\Seeders;

use App\Models\Post;
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
        $posts = collect([
            [
                'category_id' => 1,
                'title' => 'Laravel is powerfull',
                'slug' => Str::slug('Laravel is powerfull'),
                'body' => 'Laravel is a powerful PHP framework that streamlines the development process, allowing developers to build robust web applications with ease and efficiency.',
            ],
            [
                'category_id' => 2,
                'title' => 'MySQL is The Best',
                'slug' => Str::slug('MySQL is The Best'),
                'body' => 'MySQL is an open-source relational database management system (RDBMS) that is widely used for storing and managing data in web applications.',
            ],
            [
                'category_id' => 3,
                'title' => 'PHP 8.0 tranformation',
                'slug' => Str::slug('PHP 8.0 tranformation'),
                'body' => 'PHP 8.0 marks a significant transformation in the language, introducing numerous enhancements and modern features that elevate its capabilities and performance.',
            ]
        ]);

        $posts->each(function ($postData) {
            Post::create($postData);
        });
    }
}
