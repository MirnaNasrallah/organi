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
        Category::create(['name' => 'Organic Foods']);
        Category::create(['name' => 'Supplements']);
        Category::create(['name' => 'Protein Products']);
        Category::create(['name' => 'Healthy Snacks']);
        Category::create(['name' => 'Superfoods']);
        Category::create(['name' => 'Vitamins']);
        Category::create(['name' => 'Meal Replacements']);
        Category::create(['name' => 'Natural Beverages']);
        Category::create(['name' => 'Nuts & Seeds']);
        Category::create(['name' => 'Organic Grains']);
        Category::create(['name' => 'Herbal Teas']);
        Category::create(['name' => 'Fitness Nutrition']);
    }
}
