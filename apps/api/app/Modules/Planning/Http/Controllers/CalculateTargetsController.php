<?php

declare(strict_types=1);

namespace App\Modules\Planning\Http\Controllers;

use App\Modules\Planning\Http\Requests\CalculateTargetsRequest;
use App\Modules\Planning\Http\Resources\TargetsResource;
use App\Modules\Planning\Targets\CalculatesTargets;

final class CalculateTargetsController
{
    public function __construct(private readonly CalculatesTargets $calculator) {}

    /**
     * Calculate daily targets.
     *
     * Daily calories and macros for a person and a goal, with the safety gates applied. Public and
     * rate-limited, for the website calculators and app onboarding. Nothing is saved.
     *
     * @unauthenticated
     */
    public function __invoke(CalculateTargetsRequest $request): TargetsResource
    {
        return new TargetsResource($this->calculator->calculate($request->toInput()));
    }
}
