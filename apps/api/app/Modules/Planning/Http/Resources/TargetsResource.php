<?php

declare(strict_types=1);

namespace App\Modules\Planning\Http\Resources;

use App\Modules\Planning\Targets\SafetyNote;
use App\Modules\Planning\Targets\Targets;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Targets $resource
 */
final class TargetsResource extends JsonResource
{
    /**
     * @return array{kcal: int, protein_g: int, carbs_g: int, fat_g: int, bmr_kcal: int, maintenance_kcal: int, notes: list<SafetyNote>, formula_version: string}
     */
    public function toArray(Request $request): array
    {
        return [
            'kcal' => $this->resource->kcal,
            'protein_g' => $this->resource->proteinG,
            'carbs_g' => $this->resource->carbsG,
            'fat_g' => $this->resource->fatG,
            'bmr_kcal' => $this->resource->bmrKcal,
            'maintenance_kcal' => $this->resource->maintenanceKcal,
            'notes' => $this->resource->notes,
            'formula_version' => $this->resource->formulaVersion,
        ];
    }
}
