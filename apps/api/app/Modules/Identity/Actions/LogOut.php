<?php

declare(strict_types=1);

namespace App\Modules\Identity\Actions;

use App\Modules\Identity\Models\User;

final class LogOut
{
    /** Revokes the token this request came with; the user's other devices stay signed in. */
    public function handle(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
