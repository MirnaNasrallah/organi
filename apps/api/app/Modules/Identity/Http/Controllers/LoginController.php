<?php

declare(strict_types=1);

namespace App\Modules\Identity\Http\Controllers;

use App\Modules\Identity\Actions\LogIn;
use App\Modules\Identity\Http\Requests\LoginRequest;
use App\Modules\Identity\Http\Resources\IssuedTokenResource;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

final class LoginController
{
    /**
     * Sign in.
     *
     * Returns a new token for this device. A wrong email and a wrong password get the same answer.
     *
     * @unauthenticated
     */
    public function __invoke(LoginRequest $request, LogIn $logIn): IssuedTokenResource
    {
        $issued = $logIn->handle(
            email: $request->string('email')->value(),
            password: $request->string('password')->value(),
            deviceName: $request->string('device_name')->value(),
        );

        if ($issued === null) {
            throw ValidationException::withMessages(['email' => Lang::get('auth.failed')]);
        }

        return new IssuedTokenResource($issued);
    }
}
