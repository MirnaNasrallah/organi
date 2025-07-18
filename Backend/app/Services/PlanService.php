<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanDay;
use App\Models\PlanItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PlanService
{
    private HealthService $healthService;

    private const ACTIVITY_MULTIPLIERS = [
        'sedentary' => 1.2,
        'lightly_active' => 1.375,
        'moderately_active' => 1.55,
        'very_active' => 1.725
    ];

    private const GOAL_ADJUSTMENTS = [
        'lose' => -500,
        'gain' => 500,
        'maintain' => 0
    ];

    private const DAYS_PER_WEEK = 7;
    private const PRODUCTS_PER_DAY = 3;

    public function __construct(HealthService $healthService)
    {
        $this->healthService = $healthService;
    }

    public function createPlan(User $user, array $data): Plan
    {
        $this->validateUserHealthData($user);
        
        $caloriesTarget = $this->calculateCalories($data['goal'], $data['activity_level'], $user);

        return DB::transaction(function() use ($user, $data, $caloriesTarget) {
            $plan = Plan::create([
                'user_id' => $user->id,
                'goal' => $data['goal'],
                'activity_level' => $data['activity_level'],
                'calories_target' => $caloriesTarget,
            ]);

            // Pre-fetch products for better performance
            $products = $this->selectOptimalProducts($data['goal'], self::DAYS_PER_WEEK * self::PRODUCTS_PER_DAY);
            
            $this->createPlanDaysInBatch($plan, $products);

            return $plan->load(['days.items.product' => function($query) {
                $query->select('id', 'name', 'nutrition_info');
            }]);
        });
    }

    private function validateUserHealthData(User $user): void
    {
        if (!$user->weight || !$user->height || !$user->age || !$user->gender) {
            throw new \InvalidArgumentException('User health data (weight, height, age, gender) is required for plan creation.');
        }
    }

    private function selectOptimalProducts(string $goal, int $count): Collection
    {
        // Use a more efficient approach than inRandomOrder() for large datasets
        $totalProducts = Product::count();
        $productIds = collect();

        // Select products based on goal preferences
        $query = Product::select(['id', 'nutrition_info']);

        if ($goal === 'lose') {
            // Prefer lower calorie products
            $query->orderByRaw('JSON_EXTRACT(nutrition_info, "$.calories") ASC');
        } elseif ($goal === 'gain') {
            // Prefer higher calorie and protein products
            $query->orderByRaw('JSON_EXTRACT(nutrition_info, "$.protein") DESC, JSON_EXTRACT(nutrition_info, "$.calories") DESC');
        } else {
            // For maintenance, use a mixed approach
            $query->orderByRaw('RAND()');
        }

        return $query->limit($count)->get();
    }

    private function createPlanDaysInBatch(Plan $plan, Collection $products): void
    {
        $planDaysData = [];
        $planItemsData = [];
        $productChunks = $products->chunk(self::PRODUCTS_PER_DAY);

        for ($dayNumber = 1; $dayNumber <= self::DAYS_PER_WEEK; $dayNumber++) {
            $dayProducts = $productChunks->get($dayNumber - 1) ?? $productChunks->first();
            
            $nutritionTotals = $this->calculateDayNutrition($dayProducts);
            
            $planDaysData[] = [
                'plan_id' => $plan->id,
                'day_number' => $dayNumber,
                'total_calories' => $nutritionTotals['calories'],
                'total_protein' => $nutritionTotals['protein'],
                'total_carbs' => $nutritionTotals['carbs'],
                'total_fat' => $nutritionTotals['fat'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Batch insert plan days
        $insertedPlanDays = DB::table('plan_days')->insert($planDaysData);
        
        // Get the inserted plan days with their IDs
        $planDays = PlanDay::where('plan_id', $plan->id)
            ->orderBy('day_number')
            ->get()
            ->keyBy('day_number');

        // Prepare plan items data
        for ($dayNumber = 1; $dayNumber <= self::DAYS_PER_WEEK; $dayNumber++) {
            $dayProducts = $productChunks->get($dayNumber - 1) ?? $productChunks->first();
            $planDay = $planDays->get($dayNumber);
            
            foreach ($dayProducts as $product) {
                $planItemsData[] = [
                    'plan_day_id' => $planDay->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Batch insert plan items
        DB::table('plan_items')->insert($planItemsData);
    }

    private function calculateDayNutrition(Collection $products): array
    {
        return $products->reduce(function($totals, $product) {
            $nutrition = $product->nutrition_info ?? [];
            return [
                'calories' => $totals['calories'] + ($nutrition['calories'] ?? 0),
                'protein' => $totals['protein'] + ($nutrition['protein'] ?? 0),
                'carbs' => $totals['carbs'] + ($nutrition['carbs'] ?? 0),
                'fat' => $totals['fat'] + ($nutrition['fat'] ?? 0)
            ];
        }, ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fat' => 0]);
    }

    private function calculateCalories(string $goal, string $activity, User $user): float
    {
        $calories = $this->healthService->calculateCalories(
            $user->weight,
            $user->height,
            $user->age,
            $user->gender,
            self::ACTIVITY_MULTIPLIERS[$activity]
        );

        return $calories + self::GOAL_ADJUSTMENTS[$goal];
    }

    public function getUserPlan(User $user): ?Plan
    {
        return $user->plans()
            ->with(['days.items.product' => function($query) {
                $query->select('id', 'name', 'nutrition_info');
            }])
            ->latest()
            ->first();
    }

    public function updatePlan(Plan $plan, array $data): Plan
    {
        $caloriesTarget = $this->calculateCalories($data['goal'], $data['activity_level'], $plan->user);
        
        $plan->update([
            'goal' => $data['goal'],
            'activity_level' => $data['activity_level'],
            'calories_target' => $caloriesTarget,
        ]);

        return $plan->load(['days.items.product']);
    }

    public function deletePlan(Plan $plan): bool
    {
        return $plan->delete();
    }
}