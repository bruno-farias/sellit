<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x < 30; $x++) {
            $user = \App\User::where('sales_person', true)->inRandomOrder()->take(1)->first();
            $customer = \App\User::where('sales_person', false)->inRandomOrder()->take(1)->first();

            $order = factory(\App\Order::class)->create([
                'user_id' => $user->id,
                'customer_id' => $customer->id
            ]);

            for ($y = 0; $y < rand(1, 5); $y++) {
                $product = \App\Product::all()->take(1)->random()->first();
                factory(\App\OrderProduct::class)->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id
                ]);
            }

        }
    }
}
