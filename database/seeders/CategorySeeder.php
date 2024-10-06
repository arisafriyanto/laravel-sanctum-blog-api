<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            [
                'name' => 'Laravel',
                'slug' => Str::slug('Laravel')
            ],
            [
                'name' => 'MySQL',
                'slug' => Str::slug('MySQL')
            ],
            [
                'name' => 'PHP 8',
                'slug' => Str::slug('PHP 8')
            ]
        ]);

        $categories->each(function ($category) {
            Category::create($category);
        });
    }
}
