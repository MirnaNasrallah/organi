<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'goal' => $this->goal,
            'activity_level' => $this->activity_level,
            'calories_target' => $this->calories_target,
            'days' => $this->days->map(function($day) {
                return [
                    'day' => $day->day_number,
                    'totals' => [
                        'calories' => $day->total_calories,
                        'protein' => $day->total_protein,
                        'carbs' => $day->total_carbs,
                        'fat' => $day->total_fat,
                    ],
                    'items' => $day->items->map(function($item) {
                        return [
                            'product' => $item->product->name,
                            'quantity' => $item->quantity,
                        ];
                    }),
                ];
            }),
        ];
    }
}
