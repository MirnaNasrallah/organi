<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Organic Foods
            [
                'name' => 'Organic Quinoa',
                'description' => 'Premium organic quinoa, rich in protein and fiber. Perfect for healthy meals.',
                'category_id' => 1,
                'nutrition_info' => [
                    'calories' => 368,
                    'protein' => 14.1,
                    'carbs' => 64.2,
                    'fat' => 6.1,
                    'fiber' => 7.0,
                    'sugar' => 4.6
                ],
                'price' => 12.99,
                'stock' => 150,
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Organic Chia Seeds',
                'description' => 'Nutrient-dense chia seeds packed with omega-3s and antioxidants.',
                'category_id' => 1,
                'nutrition_info' => [
                    'calories' => 486,
                    'protein' => 16.5,
                    'carbs' => 42.1,
                    'fat' => 30.7,
                    'fiber' => 34.4,
                    'sugar' => 0.0
                ],
                'price' => 15.99,
                'stock' => 120,
                'image' => 'https://images.unsplash.com/photo-1553957014-bf6e9e1a9c8e?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Organic Coconut Oil',
                'description' => 'Virgin coconut oil, perfect for cooking and baking.',
                'category_id' => 1,
                'nutrition_info' => [
                    'calories' => 862,
                    'protein' => 0.0,
                    'carbs' => 0.0,
                    'fat' => 99.1,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 18.99,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400&h=400&fit=crop'
            ],

            // Supplements
            [
                'name' => 'Vitamin D3 Supplement',
                'description' => 'High-potency Vitamin D3 for bone health and immune support.',
                'category_id' => 2,
                'nutrition_info' => [
                    'calories' => 5,
                    'protein' => 0.0,
                    'carbs' => 1.0,
                    'fat' => 0.0,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 24.99,
                'stock' => 200,
                'image' => 'https://images.unsplash.com/photo-1550572017-edd951b55104?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Omega-3 Fish Oil',
                'description' => 'Pure omega-3 fish oil capsules for heart and brain health.',
                'category_id' => 2,
                'nutrition_info' => [
                    'calories' => 9,
                    'protein' => 0.0,
                    'carbs' => 0.0,
                    'fat' => 1.0,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 29.99,
                'stock' => 150,
                'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=400&fit=crop'
            ],

            // Protein Products
            [
                'name' => 'Whey Protein Powder',
                'description' => 'Premium whey protein isolate for muscle building and recovery.',
                'category_id' => 3,
                'nutrition_info' => [
                    'calories' => 120,
                    'protein' => 25.0,
                    'carbs' => 2.0,
                    'fat' => 1.0,
                    'fiber' => 0.0,
                    'sugar' => 1.0
                ],
                'price' => 49.99,
                'stock' => 75,
                'image' => 'https://images.unsplash.com/photo-1593095948071-474c5cc2989d?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Plant-Based Protein',
                'description' => 'Organic plant-based protein blend from pea and hemp.',
                'category_id' => 3,
                'nutrition_info' => [
                    'calories' => 110,
                    'protein' => 20.0,
                    'carbs' => 4.0,
                    'fat' => 2.0,
                    'fiber' => 3.0,
                    'sugar' => 0.0
                ],
                'price' => 39.99,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1605296867304-46d5465a13f1?w=400&h=400&fit=crop'
            ],

            // Healthy Snacks
            [
                'name' => 'Mixed Nuts Trail Mix',
                'description' => 'Delicious mix of almonds, walnuts, and cashews.',
                'category_id' => 4,
                'nutrition_info' => [
                    'calories' => 607,
                    'protein' => 20.2,
                    'carbs' => 22.0,
                    'fat' => 54.1,
                    'fiber' => 11.5,
                    'sugar' => 8.2
                ],
                'price' => 16.99,
                'stock' => 90,
                'image' => 'https://images.unsplash.com/photo-1599599810694-57a2ca8276a8?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Organic Protein Bars',
                'description' => 'Healthy protein bars made with organic ingredients.',
                'category_id' => 4,
                'nutrition_info' => [
                    'calories' => 190,
                    'protein' => 12.0,
                    'carbs' => 22.0,
                    'fat' => 7.0,
                    'fiber' => 4.0,
                    'sugar' => 8.0
                ],
                'price' => 2.99,
                'stock' => 200,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop'
            ],

            // Superfoods
            [
                'name' => 'Organic Spirulina Powder',
                'description' => 'Pure spirulina powder, rich in vitamins and minerals.',
                'category_id' => 5,
                'nutrition_info' => [
                    'calories' => 290,
                    'protein' => 57.5,
                    'carbs' => 23.9,
                    'fat' => 7.7,
                    'fiber' => 3.6,
                    'sugar' => 3.1
                ],
                'price' => 34.99,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1609501676725-7186f734b14c?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Acai Berry Powder',
                'description' => 'Freeze-dried acai berry powder loaded with antioxidants.',
                'category_id' => 5,
                'nutrition_info' => [
                    'calories' => 534,
                    'protein' => 8.1,
                    'carbs' => 52.2,
                    'fat' => 32.5,
                    'fiber' => 44.2,
                    'sugar' => 2.3
                ],
                'price' => 28.99,
                'stock' => 55,
                'image' => 'https://images.unsplash.com/photo-1553575997-ac3bfdc84f9c?w=400&h=400&fit=crop'
            ],

            // Vitamins
            [
                'name' => 'Multivitamin Complex',
                'description' => 'Complete multivitamin with essential nutrients.',
                'category_id' => 6,
                'nutrition_info' => [
                    'calories' => 10,
                    'protein' => 0.0,
                    'carbs' => 2.0,
                    'fat' => 0.0,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 22.99,
                'stock' => 180,
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Vitamin C Tablets',
                'description' => 'High-dose vitamin C for immune system support.',
                'category_id' => 6,
                'nutrition_info' => [
                    'calories' => 4,
                    'protein' => 0.0,
                    'carbs' => 1.0,
                    'fat' => 0.0,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 14.99,
                'stock' => 220,
                'image' => 'https://images.unsplash.com/photo-1607619662634-3ac55ec0e216?w=400&h=400&fit=crop'
            ],

            // Meal Replacements
            [
                'name' => 'Complete Meal Shake',
                'description' => 'Nutritionally complete meal replacement shake.',
                'category_id' => 7,
                'nutrition_info' => [
                    'calories' => 400,
                    'protein' => 20.0,
                    'carbs' => 40.0,
                    'fat' => 15.0,
                    'fiber' => 8.0,
                    'sugar' => 12.0
                ],
                'price' => 42.99,
                'stock' => 65,
                'image' => 'https://images.unsplash.com/photo-1594882645126-14020914d58d?w=400&h=400&fit=crop'
            ],

            // Natural Beverages
            [
                'name' => 'Green Tea Extract',
                'description' => 'Organic green tea extract for natural energy.',
                'category_id' => 8,
                'nutrition_info' => [
                    'calories' => 2,
                    'protein' => 0.0,
                    'carbs' => 0.0,
                    'fat' => 0.0,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 19.99,
                'stock' => 85,
                'image' => 'https://images.unsplash.com/photo-1556881286-7c3e7eada3b6?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Coconut Water',
                'description' => 'Pure coconut water for natural hydration.',
                'category_id' => 8,
                'nutrition_info' => [
                    'calories' => 19,
                    'protein' => 0.7,
                    'carbs' => 3.7,
                    'fat' => 0.2,
                    'fiber' => 1.1,
                    'sugar' => 2.6
                ],
                'price' => 3.99,
                'stock' => 300,
                'image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=400&fit=crop'
            ],

            // Nuts & Seeds
            [
                'name' => 'Raw Almonds',
                'description' => 'Premium raw almonds, perfect for snacking.',
                'category_id' => 9,
                'nutrition_info' => [
                    'calories' => 579,
                    'protein' => 21.2,
                    'carbs' => 21.6,
                    'fat' => 49.9,
                    'fiber' => 12.5,
                    'sugar' => 4.4
                ],
                'price' => 13.99,
                'stock' => 110,
                'image' => 'https://images.unsplash.com/photo-1508747703725-719777637510?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Pumpkin Seeds',
                'description' => 'Roasted pumpkin seeds rich in magnesium.',
                'category_id' => 9,
                'nutrition_info' => [
                    'calories' => 559,
                    'protein' => 30.2,
                    'carbs' => 10.7,
                    'fat' => 49.1,
                    'fiber' => 6.0,
                    'sugar' => 1.4
                ],
                'price' => 11.99,
                'stock' => 95,
                'image' => 'https://images.unsplash.com/photo-1605027990121-cbae9ea5b5de?w=400&h=400&fit=crop'
            ],

            // Organic Grains
            [
                'name' => 'Organic Brown Rice',
                'description' => 'Whole grain brown rice, high in fiber and nutrients.',
                'category_id' => 10,
                'nutrition_info' => [
                    'calories' => 370,
                    'protein' => 7.9,
                    'carbs' => 77.2,
                    'fat' => 2.9,
                    'fiber' => 3.5,
                    'sugar' => 0.7
                ],
                'price' => 8.99,
                'stock' => 140,
                'image' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Organic Oats',
                'description' => 'Steel-cut organic oats for healthy breakfast.',
                'category_id' => 10,
                'nutrition_info' => [
                    'calories' => 379,
                    'protein' => 13.2,
                    'carbs' => 67.7,
                    'fat' => 6.5,
                    'fiber' => 10.1,
                    'sugar' => 1.1
                ],
                'price' => 7.99,
                'stock' => 160,
                'image' => 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400&h=400&fit=crop'
            ],

            // Herbal Teas
            [
                'name' => 'Chamomile Tea',
                'description' => 'Relaxing chamomile tea for better sleep.',
                'category_id' => 11,
                'nutrition_info' => [
                    'calories' => 1,
                    'protein' => 0.0,
                    'carbs' => 0.2,
                    'fat' => 0.0,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 12.99,
                'stock' => 75,
                'image' => 'https://images.unsplash.com/photo-1597318022111-7a47093c41bc?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'Ginger Turmeric Tea',
                'description' => 'Anti-inflammatory herbal tea blend.',
                'category_id' => 11,
                'nutrition_info' => [
                    'calories' => 2,
                    'protein' => 0.1,
                    'carbs' => 0.4,
                    'fat' => 0.0,
                    'fiber' => 0.1,
                    'sugar' => 0.0
                ],
                'price' => 15.99,
                'stock' => 65,
                'image' => 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=400&h=400&fit=crop'
            ],

            // Fitness Nutrition
            [
                'name' => 'Pre-Workout Formula',
                'description' => 'Natural pre-workout supplement for enhanced performance.',
                'category_id' => 12,
                'nutrition_info' => [
                    'calories' => 15,
                    'protein' => 0.0,
                    'carbs' => 4.0,
                    'fat' => 0.0,
                    'fiber' => 0.0,
                    'sugar' => 2.0
                ],
                'price' => 32.99,
                'stock' => 55,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop'
            ],
            [
                'name' => 'BCAA Powder',
                'description' => 'Branched-chain amino acids for muscle recovery.',
                'category_id' => 12,
                'nutrition_info' => [
                    'calories' => 10,
                    'protein' => 2.5,
                    'carbs' => 0.0,
                    'fat' => 0.0,
                    'fiber' => 0.0,
                    'sugar' => 0.0
                ],
                'price' => 27.99,
                'stock' => 70,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
