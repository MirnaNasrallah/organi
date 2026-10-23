<?php

declare(strict_types=1);

namespace App\Modules\Planning\Targets;

/** Why the targets differ from what was asked for. The apps explain each one to the person. */
enum SafetyNote: string
{
    /** Under 18 or a reported condition: maintenance only, and a professional's advice. */
    case SeeAProfessional = 'see_a_professional';

    /** The requested pace was faster than the safe weekly rate. */
    case PaceCapped = 'pace_capped';

    /** The target fell below the daily calorie floor and was raised to it. */
    case RaisedToCalorieFloor = 'raised_to_calorie_floor';
}
