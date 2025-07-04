<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wishlist;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wishlists = [
            // Sarah Johnson (user_id: 2) - Premium user wishlist
            ['user_id' => 2, 'product_id' => 1], // Organic Quinoa
            ['user_id' => 2, 'product_id' => 6], // Whey Protein Powder
            ['user_id' => 2, 'product_id' => 10], // Organic Spirulina Powder
            ['user_id' => 2, 'product_id' => 13], // Complete Meal Shake

            // Michael Chen (user_id: 3) - Premium user wishlist
            ['user_id' => 3, 'product_id' => 6], // Whey Protein Powder
            ['user_id' => 3, 'product_id' => 7], // Plant-Based Protein
            ['user_id' => 3, 'product_id' => 22], // Pre-Workout Formula
            ['user_id' => 3, 'product_id' => 23], // BCAA Powder

            // John Doe (user_id: 5) - Regular user wishlist
            ['user_id' => 5, 'product_id' => 2], // Organic Chia Seeds
            ['user_id' => 5, 'product_id' => 8], // Mixed Nuts Trail Mix
            ['user_id' => 5, 'product_id' => 16], // Raw Almonds
            ['user_id' => 5, 'product_id' => 18], // Organic Brown Rice

            // Lisa Anderson (user_id: 6) - Regular user wishlist
            ['user_id' => 6, 'product_id' => 4], // Vitamin D3 Supplement
            ['user_id' => 6, 'product_id' => 11], // Multivitamin Complex
            ['user_id' => 6, 'product_id' => 20], // Chamomile Tea
            ['user_id' => 6, 'product_id' => 15], // Coconut Water

            // David Rodriguez (user_id: 7) - Regular user wishlist
            ['user_id' => 7, 'product_id' => 6], // Whey Protein Powder
            ['user_id' => 7, 'product_id' => 8], // Mixed Nuts Trail Mix
            ['user_id' => 7, 'product_id' => 22], // Pre-Workout Formula

            // Jennifer Kim (user_id: 8) - Cancelled subscription wishlist
            ['user_id' => 8, 'product_id' => 2], // Organic Chia Seeds
            ['user_id' => 8, 'product_id' => 9], // Organic Protein Bars
            ['user_id' => 8, 'product_id' => 19], // Organic Oats

            // Robert Taylor (user_id: 9) - Regular user wishlist
            ['user_id' => 9, 'product_id' => 1], // Organic Quinoa
            ['user_id' => 9, 'product_id' => 13], // Complete Meal Shake
            ['user_id' => 9, 'product_id' => 23], // BCAA Powder

            // Amanda Brown (user_id: 10) - Regular user wishlist
            ['user_id' => 10, 'product_id' => 10], // Organic Spirulina Powder
            ['user_id' => 10, 'product_id' => 11], // Acai Berry Powder
            ['user_id' => 10, 'product_id' => 20], // Chamomile Tea
            ['user_id' => 10, 'product_id' => 21], // Ginger Turmeric Tea
        ];

        foreach ($wishlists as $wishlist) {
            Wishlist::create($wishlist);
        }
    }
}
