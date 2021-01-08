<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(App\User::class, 3)->create();
        factory(App\Client::class, 10)->create();
        factory(App\Tiket::class, 100)->create();
    }
}
