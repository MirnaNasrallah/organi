<?php

declare(strict_types=1);

namespace App\Modules\Shared\Http\Resources;

use App\Modules\Shared\Locale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Locale $resource
 */
final class StatusResource extends JsonResource
{
    /**
     * @return array{status: 'ok', locale: Locale}
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'ok',
            'locale' => $this->resource,
        ];
    }
}
