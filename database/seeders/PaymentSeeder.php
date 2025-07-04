<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            // Payment for Order 1 - Sarah Johnson
            [
                'user_id' => 2,
                'order_id' => 1,
                'amount' => 45.97,
                'status' => 'completed',
                'payment_method' => 'credit_card',
            ],

            // Payment for Order 2 - Michael Chen
            [
                'user_id' => 3,
                'order_id' => 2,
                'amount' => 109.97,
                'status' => 'completed',
                'payment_method' => 'paypal',
            ],

            // Payment for Order 3 - John Doe
            [
                'user_id' => 5,
                'order_id' => 3,
                'amount' => 34.95,
                'status' => 'completed',
                'payment_method' => 'credit_card',
            ],

            // Payment for Order 4 - Lisa Anderson
            [
                'user_id' => 6,
                'order_id' => 4,
                'amount' => 62.97,
                'status' => 'pending',
                'payment_method' => 'bank_transfer',
            ],

            // Payment for Order 5 - David Rodriguez
            [
                'user_id' => 7,
                'order_id' => 5,
                'amount' => 76.97,
                'status' => 'pending',
                'payment_method' => 'credit_card',
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}
