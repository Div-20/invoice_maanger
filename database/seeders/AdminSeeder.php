<?php

namespace Database\Seeders;

use App\Helpers\CustomHelper;
use App\Helpers\SiteConstants;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=AdminSeeder
        \DB::table('admins')->insert(
            array(
                'role' => SiteConstants::ROLE_ADMIN,
                'unique_id' => CustomHelper::generatePassword(5, 4),
                'username' => 'mohit94x',
                'name' => 'superadmin',
                'email' => 'admin@gmail.com',
                'mobile' => 8769396605,
                'password' => Hash::make('123456789'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'block' => 0,
            )
        );
    }
}
