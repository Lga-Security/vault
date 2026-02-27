<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $categories = [
        ['name' => 'Social Media', 'is_default' => true],
        ['name' => 'Email', 'is_default' => true],
        ['name' => 'Banking', 'is_default' => true],
        ['name' => 'Shopping', 'is_default' => true],
        ['name' => 'Entertainment', 'is_default' => true],
        ['name' => 'Development', 'is_default' => true],
        ['name' => 'Other', 'is_default' => true],
    ];

    foreach ($categories as $category) {
        Category::create($category);
    }
}
}