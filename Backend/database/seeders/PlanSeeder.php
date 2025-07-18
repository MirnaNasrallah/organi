<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\PlanDay;
use App\Models\PlanItem;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Plan 1 - Sarah Johnson (Weight Loss Plan)
        $plan1 = Plan::create([
            'user_id' => 2,
            'goal' => 'lose',
            'activity_level' => 'moderately_active',
            'calories_target' => 1800.00,
        ]);

        // Week plan for Sarah (7 days)
        for ($day = 1; $day <= 7; $day++) {
            $planDay = PlanDay::create([
                'plan_id' => $plan1->id,
                'day_number' => $day,
                'total_calories' => 1800.00,
                'total_protein' => 120.00,
            ]);

            // Day plan items (breakfast, lunch, dinner, snack)
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 19, 'quantity' => 50]); // Organic Oats
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 1, 'quantity' => 150]); // Organic Quinoa
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 16, 'quantity' => 30]); // Raw Almonds
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 9, 'quantity' => 1]); // Organic Protein Bar
        }

        // Plan 2 - Michael Chen (Muscle Building Plan)
        $plan2 = Plan::create([
            'user_id' => 3,
            'goal' => 'gain',
            'activity_level' => 'very_active',
            'calories_target' => 2500.00,
        ]);

        // Week plan for Michael (7 days)
        for ($day = 1; $day <= 7; $day++) {
            $planDay = PlanDay::create([
                'plan_id' => $plan2->id,
                'day_number' => $day,
                'total_calories' => 2500.00,
                'total_protein' => 180.00,
            ]);

            // Day plan items (high protein focus)
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 6, 'quantity' => 30]); // Whey Protein Powder
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 1, 'quantity' => 200]); // Organic Quinoa
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 8, 'quantity' => 50]); // Mixed Nuts Trail Mix
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 18, 'quantity' => 150]); // Organic Brown Rice
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 16, 'quantity' => 40]); // Raw Almonds
        }

        // Plan 3 - Emma Williams (Maintenance Plan - expired premium)
        $plan3 = Plan::create([
            'user_id' => 4,
            'goal' => 'maintain',
            'activity_level' => 'lightly_active',
            'calories_target' => 2000.00,
        ]);

        // Week plan for Emma (7 days)
        for ($day = 1; $day <= 7; $day++) {
            $planDay = PlanDay::create([
                'plan_id' => $plan3->id,
                'day_number' => $day,
                'total_calories' => 2000.00,
                'total_protein' => 100.00,
            ]);

            // Day plan items (balanced nutrition)
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 19, 'quantity' => 60]); // Organic Oats
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 1, 'quantity' => 120]); // Organic Quinoa
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 2, 'quantity' => 20]); // Organic Chia Seeds
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 9, 'quantity' => 2]); // Organic Protein Bar
            PlanItem::create(['plan_day_id' => $planDay->id, 'product_id' => 16, 'quantity' => 25]); // Raw Almonds
        }
    }
}
