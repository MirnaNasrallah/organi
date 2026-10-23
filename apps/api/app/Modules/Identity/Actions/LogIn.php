<?php

declare(strict_types=1);

namespace App\Modules\Identity\Actions;

use App\Modules\Identity\Email;
use App\Modules\Identity\Models\User;
use Illuminate\Contracts\Auth\Factory as Auth;
use SensitiveParameter;

final class LogIn
{
    public function __construct(private readonly Auth $auth) {}

    /** A token for this device, or null when the email or password is wrong (callers can't tell which). */
    public function handle(string $email, #[SensitiveParameter] string $password, string $deviceName): ?IssuedToken
    {
        $email = Email::normalise($email);

        // validate() takes the same time whether or not the email exists, so timing can't reveal accounts.
        if (! $this->auth->guard('web')->validate(['email' => $email, 'password' => $password])) {
            return null;
        }

        $user = User::query()->where('email', $email)->firstOrFail();

        return new IssuedToken($user, $user->createToken($deviceName)->plainTextToken);
    }
}
