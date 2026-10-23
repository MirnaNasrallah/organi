<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

enum Sex: string
{
    case Female = 'female';
    case Male = 'male';

    private const array MIN_DAILY_KCAL = [
        'female' => TargetRules::MIN_DAILY_KCAL_FEMALE,
        'male' => TargetRules::MIN_DAILY_KCAL_MALE,
    ];

    public function minDailyKcal(): int
    {
        return self::MIN_DAILY_KCAL[$this->value];
    }
}
