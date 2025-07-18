<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = [
            // Sarah Johnson (user_id: 2) - Premium user cart
            ['user_id' => 2, 'product_id' => 1, 'quantity' => 2], // Organic Quinoa
            ['user_id' => 2, 'product_id' => 2, 'quantity' => 1], // Organic Chia Seeds
            ['user_id' => 2, 'product_id' => 9, 'quantity' => 3], // Organic Protein Bars

            // Michael Chen (user_id: 3) - Premium user cart
            ['user_id' => 3, 'product_id' => 6, 'quantity' => 1], // Whey Protein Powder
            ['user_id' => 3, 'product_id' => 22, 'quantity' => 1], // Pre-Workout Formula
            ['user_id' => 3, 'product_id' => 16, 'quantity' => 2], // Raw Almonds

            // John Doe (user_id: 5) - Regular user cart
            ['user_id' => 5, 'product_id' => 8, 'quantity' => 1], // Mixed Nuts Trail Mix
            ['user_id' => 5, 'product_id' => 18, 'quantity' => 1], // Organic Brown Rice
            ['user_id' => 5, 'product_id' => 15, 'quantity' => 4], // Coconut Water

            // Lisa Anderson (user_id: 6) - Regular user cart
            ['user_id' => 6, 'product_id' => 4, 'quantity' => 1], // Vitamin D3 Supplement
            ['user_id' => 6, 'product_id' => 20, 'quantity' => 2], // Chamomile Tea

            // David Rodriguez (user_id: 7) - Regular user cart
            ['user_id' => 7, 'product_id' => 13, 'quantity' => 1], // Complete Meal Shake
            ['user_id' => 7, 'product_id' => 8, 'quantity' => 2], // Mixed Nuts Trail Mix

            // Jennifer Kim (user_id: 8) - Cancelled subscription cart
            ['user_id' => 8, 'product_id' => 9, 'quantity' => 5], // Organic Protein Bars
            ['user_id' => 8, 'product_id' => 19, 'quantity' => 1], // Organic Oats

            // Robert Taylor (user_id: 9) - Regular user cart
            ['user_id' => 9, 'product_id' => 1, 'quantity' => 1], // Organic Quinoa
            ['user_id' => 9, 'product_id' => 5, 'quantity' => 1], // Omega-3 Fish Oil

            // Amanda Brown (user_id: 10) - Regular user cart
            ['user_id' => 10, 'product_id' => 10, 'quantity' => 1], // Organic Spirulina Powder
            ['user_id' => 10, 'product_id' => 21, 'quantity' => 2], // Ginger Turmeric Tea
            ['user_id' => 10, 'product_id' => 12, 'quantity' => 1], // Vitamin C Tablets
        ];

        foreach ($carts as $cart) {
            Cart::create($cart);
        }
    }
}
