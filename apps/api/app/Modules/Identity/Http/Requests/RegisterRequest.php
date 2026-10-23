<?php

declare(strict_types=1);

namespace App\Modules\Identity\Http\Requests;

use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class RegisterRequest extends FormRequest
{
    use NormalisesEmail;

    private const int MAX_LENGTH = 255;

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:'.self::MAX_LENGTH],
            'email' => ['required', 'string', 'email', 'max:'.self::MAX_LENGTH, Rule::unique(User::class, 'email')],
            'password' => ['required', 'string', Password::defaults()],
            'device_name' => ['required', 'string', 'max:'.self::MAX_LENGTH],
        ];
    }
}
