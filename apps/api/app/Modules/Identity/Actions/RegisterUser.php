<?php

declare(strict_types=1);

namespace App\Modules\Identity\Actions;

use App\Modules\Identity\Models\User;
use SensitiveParameter;

final class RegisterUser
{
    public function handle(string $name, string $email, #[SensitiveParameter] string $password, string $deviceName): IssuedToken
    {
        $user = User::create(['name' => $name, 'email' => $email, 'password' => $password]);

        return new IssuedToken($user, $user->createToken($deviceName)->plainTextToken);
    }
}
