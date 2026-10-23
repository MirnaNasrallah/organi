<?php

declare(strict_types=1);

namespace App\Modules\Shared\Http\Requests;

use App\Modules\Shared\Digits;

use function is_string;

/** For Form Requests with number fields: Eastern Arabic digits are accepted and converted before validation (ADR 0006). */
trait NormalisesDigits
{
    /**
     * @return list<string>
     */
    abstract protected function numberFields(): array;

    protected function prepareForValidation(): void
    {
        $normalised = [];

        foreach ($this->numberFields() as $field) {
            $value = $this->input($field);

            if (is_string($value)) {
                $normalised[$field] = Digits::toWestern($value);
            }
        }

        $this->merge($normalised);
    }
}
