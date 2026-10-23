<?php

declare(strict_types=1);

namespace App\Modules\Shared\Http\Controllers;

use App\Modules\Shared\Http\Resources\StatusResource;
use App\Modules\Shared\Locale;

final class StatusController
{
    /**
     * API status.
     *
     * Liveness, plus the language the API negotiated from Accept-Language.
     *
     * @unauthenticated
     */
    public function __invoke(): StatusResource
    {
        return new StatusResource(Locale::current());
    }
}
