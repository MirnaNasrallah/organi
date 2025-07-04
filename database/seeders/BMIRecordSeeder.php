<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BMIRecord;

class BMIRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bmiRecords = [
            // Sarah Johnson (user_id: 2) - Premium user tracking progress
            [
                'user_id' => 2,
                'weight' => 68.5,
                'height' => 165.0,
                'bmi' => 25.2,
            ],
            [
                'user_id' => 2,
                'weight' => 67.2,
                'height' => 165.0,
                'bmi' => 24.7,
            ],
            [
                'user_id' => 2,
                'weight' => 65.8,
                'height' => 165.0,
                'bmi' => 24.2,
            ],

            // Michael Chen (user_id: 3) - Premium user
            [
                'user_id' => 3,
                'weight' => 78.3,
                'height' => 175.0,
                'bmi' => 25.6,
            ],
            [
                'user_id' => 3,
                'weight' => 76.8,
                'height' => 175.0,
                'bmi' => 25.1,
            ],

            // Emma Williams (user_id: 4) - Expired premium
            [
                'user_id' => 4,
                'weight' => 58.2,
                'height' => 160.0,
                'bmi' => 22.7,
            ],

            // John Doe (user_id: 5) - Regular user
            [
                'user_id' => 5,
                'weight' => 82.1,
                'height' => 180.0,
                'bmi' => 25.3,
            ],

            // Lisa Anderson (user_id: 6) - Regular user
            [
                'user_id' => 6,
                'weight' => 62.5,
                'height' => 168.0,
                'bmi' => 22.1,
            ],
            [
                'user_id' => 6,
                'weight' => 61.8,
                'height' => 168.0,
                'bmi' => 21.9,
            ],

            // David Rodriguez (user_id: 7) - Regular user
            [
                'user_id' => 7,
                'weight' => 85.4,
                'height' => 178.0,
                'bmi' => 27.0,
            ],

            // Jennifer Kim (user_id: 8) - Cancelled subscription
            [
                'user_id' => 8,
                'weight' => 55.3,
                'height' => 162.0,
                'bmi' => 21.1,
            ],

            // Robert Taylor (user_id: 9) - Regular user
            [
                'user_id' => 9,
                'weight' => 88.7,
                'height' => 185.0,
                'bmi' => 25.9,
            ],

            // Amanda Brown (user_id: 10) - Regular user
            [
                'user_id' => 10,
                'weight' => 64.2,
                'height' => 170.0,
                'bmi' => 22.2,
            ],
        ];

        foreach ($bmiRecords as $record) {
            BMIRecord::create($record);
        }
    }
}
