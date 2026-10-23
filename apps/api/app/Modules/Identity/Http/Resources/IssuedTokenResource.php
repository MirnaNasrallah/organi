<?php

declare(strict_types=1);

namespace App\Modules\Identity\Http\Resources;

use App\Modules\Identity\Actions\IssuedToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read IssuedToken $resource
 */
final class IssuedTokenResource extends JsonResource
{
    /**
     * @return array{token: string, token_type: 'Bearer', user: UserResource}
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->resource->plainTextToken,
            'token_type' => 'Bearer',
            'user' => new UserResource($this->resource->user),
        ];
    }
}
