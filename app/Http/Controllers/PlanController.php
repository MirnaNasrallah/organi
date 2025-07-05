<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Models\User;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    private PlanService $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the plans.
     */
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $plans = Plan::with(['user', 'days.items.product'])->get();
        } else {
            $plans = $user->plans()->with(['days.items.product'])->get();
        }
        
        return response()->json(PlanResource::collection($plans));
    }

    /**
     * Store a newly created plan in storage.
     */
    public function store(PlanRequest $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            $plan = $this->planService->createPlan($user, $request->validated());
            
            return response()->json([
                'message' => 'Plan created successfully',
                'data' => new PlanResource($plan)
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => 'Invalid user data',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified plan.
     */
    public function show(Plan $plan): JsonResponse
    {
        $this->authorize('view', $plan);
        
        $plan->load(['days.items.product']);
        return response()->json(new PlanResource($plan));
    }

    /**
     * Update the specified plan in storage.
     */
    public function update(PlanRequest $request, Plan $plan): JsonResponse
    {
        try {
            $this->authorize('update', $plan);
            
            $updatedPlan = $this->planService->updatePlan($plan, $request->validated());
            
            return response()->json([
                'message' => 'Plan updated successfully',
                'data' => new PlanResource($updatedPlan)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified plan from storage.
     */
    public function destroy(Plan $plan): JsonResponse
    {
        try {
            $this->authorize('delete', $plan);
            
            $this->planService->deletePlan($plan);
            
            return response()->json([
                'message' => 'Plan deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the authenticated user's current plan.
     */
    public function myPlan(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $plan = $this->planService->getUserPlan($user);
        
        if (!$plan) {
            return response()->json([
                'message' => 'No plan found for user'
            ], 404);
        }
        
        return response()->json(new PlanResource($plan));
    }
}
