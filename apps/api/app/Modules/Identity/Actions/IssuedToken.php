<?php

declare(strict_types=1);

namespace App\Modules\Identity\Actions;

use App\Modules\Identity\Models\User;
use SensitiveParameter;

/** A new device token. The plain text is shown once, to the device that asked for it. */
final readonly class IssuedToken
{
    public function __construct(
        public User $user,
        #[SensitiveParameter] public string $plainTextToken,
    ) {}
}
