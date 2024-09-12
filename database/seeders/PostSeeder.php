<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts_count = (int)$this->command->ask('How many posts wish to create?', 50);
        $categories = Category::all();

        \App\Models\Post::factory($posts_count)->make()->each(function($post) use($categories) {
            $post->category_id = $categories->random()->id;
            $post->image = 'img-01.jpg';
            $post->save();
        }); 
    }
}
