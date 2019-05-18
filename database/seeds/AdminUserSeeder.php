<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 1)->create([
            'admin' => true,
            'email' => 'admin@admin.com',
            'password' => bcrypt('Admin123')
        ]);
    }
}
