<?php

declare(strict_types=1);

namespace App\Modules\Identity\Http\Requests;

use App\Modules\Identity\Email;

use function is_string;

/** Normalises the email before validation, so "unique" and sign-in ignore case and spacing. */
trait NormalisesEmail
{
    protected function prepareForValidation(): void
    {
        $email = $this->input('email');

        if (is_string($email)) {
            $this->merge(['email' => Email::normalise($email)]);
        }
    }
}
