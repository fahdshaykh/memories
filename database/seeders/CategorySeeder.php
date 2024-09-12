<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_count = (int)$this->command->ask('How many categories wish to create?', 20);

        \App\Models\Category::factory($category_count)->create();
    }
}
