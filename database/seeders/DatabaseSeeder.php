<?php

namespace Database\Seeders;

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
        $this->call([
            AdminSeeder::class,
            AutoIncrementSeeder::class,
            // LocationCountrySeeder::class,
            // LocationStateSeeder::class,
            // LocationCitySeeder::class,
            RoleSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
