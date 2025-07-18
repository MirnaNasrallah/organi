<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Order 1 - Sarah Johnson (Premium user)
        $order1 = Order::create([
            'user_id' => 2,
            'total' => 45.97,
            'status' => 'delivered',
        ]);
        
        OrderItem::create(['order_id' => $order1->id, 'product_id' => 1, 'quantity' => 1, 'price_at_time' => 12.99]);
        OrderItem::create(['order_id' => $order1->id, 'product_id' => 2, 'quantity' => 1, 'price_at_time' => 15.99]);
        OrderItem::create(['order_id' => $order1->id, 'product_id' => 8, 'quantity' => 1, 'price_at_time' => 16.99]);

        // Order 2 - Michael Chen (Premium user)
        $order2 = Order::create([
            'user_id' => 3,
            'total' => 109.97,
            'status' => 'shipped',
        ]);
        
        OrderItem::create(['order_id' => $order2->id, 'product_id' => 6, 'quantity' => 1, 'price_at_time' => 49.99]);
        OrderItem::create(['order_id' => $order2->id, 'product_id' => 22, 'quantity' => 1, 'price_at_time' => 32.99]);
        OrderItem::create(['order_id' => $order2->id, 'product_id' => 23, 'quantity' => 1, 'price_at_time' => 27.99]);

        // Order 3 - John Doe (Regular user)
        $order3 = Order::create([
            'user_id' => 5,
            'total' => 34.95,
            'status' => 'delivered',
        ]);
        
        OrderItem::create(['order_id' => $order3->id, 'product_id' => 18, 'quantity' => 1, 'price_at_time' => 8.99]);
        OrderItem::create(['order_id' => $order3->id, 'product_id' => 15, 'quantity' => 4, 'price_at_time' => 3.99]);
        OrderItem::create(['order_id' => $order3->id, 'product_id' => 9, 'quantity' => 3, 'price_at_time' => 2.99]);

        // Order 4 - Lisa Anderson (Regular user)
        $order4 = Order::create([
            'user_id' => 6,
            'total' => 62.97,
            'status' => 'processing',
        ]);
        
        OrderItem::create(['order_id' => $order4->id, 'product_id' => 4, 'quantity' => 1, 'price_at_time' => 24.99]);
        OrderItem::create(['order_id' => $order4->id, 'product_id' => 11, 'quantity' => 1, 'price_at_time' => 22.99]);
        OrderItem::create(['order_id' => $order4->id, 'product_id' => 12, 'quantity' => 1, 'price_at_time' => 14.99]);

        // Order 5 - David Rodriguez (Regular user)
        $order5 = Order::create([
            'user_id' => 7,
            'total' => 76.97,
            'status' => 'pending',
        ]);
        
        OrderItem::create(['order_id' => $order5->id, 'product_id' => 13, 'quantity' => 1, 'price_at_time' => 42.99]);
        OrderItem::create(['order_id' => $order5->id, 'product_id' => 8, 'quantity' => 2, 'price_at_time' => 16.99]);
    }
}
