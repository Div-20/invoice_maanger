<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super_admin','display_name'=> 'Super Admin','status'=>1]);
        Role::create(['name' => 'product_admin','display_name'=> 'Product Admin','status'=>1]);
        Role::create(['name' => 'physical_user','display_name'=> 'Physical Verification User','status'=>1]);
    }
}
