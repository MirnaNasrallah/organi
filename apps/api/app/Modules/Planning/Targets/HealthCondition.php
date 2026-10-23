<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

/** Anything a person reports that rules out a deficit and sends them to a professional (PLAN §4.3). */
enum HealthCondition: string
{
    case Pregnant = 'pregnant';
    case Breastfeeding = 'breastfeeding';
    case Diabetes = 'diabetes';
    case KidneyDisease = 'kidney_disease';
    case EatingDisorderHistory = 'eating_disorder_history';
}
