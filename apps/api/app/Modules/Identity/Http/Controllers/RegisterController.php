<?php

declare(strict_types=1);

namespace App\Modules\Identity\Http\Controllers;

use App\Modules\Identity\Actions\RegisterUser;
use App\Modules\Identity\Http\Requests\RegisterRequest;
use App\Modules\Identity\Http\Resources\IssuedTokenResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegisterController
{
    /**
     * Create an account.
     *
     * Returns a token for this device: keep it in secure storage and send it as a bearer token.
     *
     * @unauthenticated
     */
    public function __invoke(RegisterRequest $request, RegisterUser $register): JsonResponse
    {
        $issued = $register->handle(
            name: $request->string('name')->value(),
            email: $request->string('email')->value(),
            password: $request->string('password')->value(),
            deviceName: $request->string('device_name')->value(),
        );

        return (new IssuedTokenResource($issued))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
