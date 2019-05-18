<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Product::class, 50)->create([
            'category_id' => \App\Category::all()->take(1)->random()->first()->id
        ]);
    }
}
