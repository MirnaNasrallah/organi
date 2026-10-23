<?php

declare(strict_types=1);

namespace App\Modules\Identity\Http\Controllers;

use App\Modules\Identity\Actions\LogOut;
use App\Modules\Identity\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;

use function response;

final class LogoutController
{
    /**
     * Sign out this device.
     *
     * Revokes the token the request was made with. Other devices stay signed in.
     */
    public function __invoke(#[CurrentUser] User $user, LogOut $logOut): Response
    {
        $logOut->handle($user);

        return response()->noContent();
    }
}
