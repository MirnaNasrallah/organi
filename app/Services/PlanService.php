<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanDay;
use App\Models\PlanItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PlanService
{
    public function createPlan(User $user, array $data)
    {
        // Calculate daily calorie target based on goal & activity
        $caloriesTarget = $this->calculateCalories($data['goal'], $data['activity_level'], $user);

        return DB::transaction(function() use ($user, $data, $caloriesTarget) {
            $plan = Plan::create([
                'user_id' => $user->id,
                'goal' => $data['goal'], 
                'activity_level' => $data['activity_level'],
                'calories_target' => $caloriesTarget,
            ]);

            $planDays = collect(range(1, 7))->map(function($dayNumber) use ($plan) {
                $planDay = PlanDay::create([
                    'plan_id' => $plan->id,
                    'day_number' => $dayNumber,
                    'total_calories' => 0,
                    'total_protein' => 0, 
                    'total_carbs' => 0,
                    'total_fat' => 0,
                ]);

                $products = Product::inRandomOrder()->limit(3)->get();
                
                $nutritionTotals = $products->reduce(function($totals, $product) use ($planDay) {
                    PlanItem::create([
                        'plan_day_id' => $planDay->id,
                        'product_id' => $product->id,
                        'quantity' => 1
                    ]);

                    return [
                        'calories' => $totals['calories'] + $product->nutrition_info['calories'],
                        'protein' => $totals['protein'] + $product->nutrition_info['protein'],
                        'carbs' => $totals['carbs'] + $product->nutrition_info['carbs'],
                        'fat' => $totals['fat'] + $product->nutrition_info['fat']
                    ];
                }, ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fat' => 0]);

                $planDay->update([
                    'total_calories' => $nutritionTotals['calories'],
                    'total_protein' => $nutritionTotals['protein'],
                    'total_carbs' => $nutritionTotals['carbs'],
                    'total_fat' => $nutritionTotals['fat']
                ]);

                return $planDay;
            });

            return $plan->load('days.items.product');
        });
    }

    private function calculateCalories($goal, $activity, $user)
    {
        $healthService = new HealthService();
        
        // Calculate base calories using BMR and activity level multiplier
        $activityMultipliers = [
            'sedentary' => 1.2,
            'lightly_active' => 1.375, 
            'moderately_active' => 1.55,
            'very_active' => 1.725
        ];
        
        $calories = $healthService->calculateCalories(
            $user->weight,
            $user->height, 
            $user->age,
            $user->gender,
            $activityMultipliers[$activity]
        );

        // Adjust calories based on goal
        $goalAdjustments = [
            'lose' => -500,
            'gain' => 500,
            'maintain' => 0
        ];

        return $calories + $goalAdjustments[$goal];
    }
}