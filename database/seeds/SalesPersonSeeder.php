<?php

use Illuminate\Database\Seeder;

class SalesPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 5)->create([
            'sales_person' => true
        ]);
    }
}
