<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutoIncrementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('auto_increments')->insert(
            [
                'auto_user' => 10000,
                'auto_cart' => 10000,
                'auto_product' => 10000,
                'auto_order' => 10000,
                'auto_sub_admin' => 10000,
                'auto_category' => 10000,
                'auto_brand' => 10000,
                'auto_transaction' => 10000,
                'auto_leads' => 10000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
