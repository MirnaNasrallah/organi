<?php

namespace App\Services;

class HealthService
{
    public function calculateBMI($weight, $height)
    {
        return $weight / ($height * $height);
    }

    public function calculateCalories($weight, $height, $age, $gender, $activityLevel)
    {
        $bmr = $this->calculateBMR($weight, $height, $age, $gender);
        return $bmr * $activityLevel;
    }

    public function calculateBMR($weight, $height, $age, $gender)
    {
        $bmr = 0;
        if ($gender == 'male') {
            $bmr = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
        } else {
            $bmr = 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
        }
        return $bmr;
    }
    
}