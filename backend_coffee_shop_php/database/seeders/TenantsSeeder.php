<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::insert($this->tenants);
    }

    private $tenants = [
        ['name' => 'bee coffee','email' => 'bee.coffee@gmail.com','domain' => 'app1.kidai.site','db_name' => 'coffee_shop','db_user' => 'root','tenant_token' => 'o7k6w328gip1'],
        ['name' => 'bee coffee 2','email' => 'bee.coffee1@gmail.com','domain' => 'app2.kidai.site','db_name' => 'coffee_shop_2','db_user' => 'root','tenant_token' => 'b6q68e469dif'],
        ['name' => 'bee coffee  3','email' => 'bee.coffee2@gmail.com','domain' => '127.0.0.1','db_name' => 'coffee_shop_2','db_user' => 'root','tenant_token' => 'k703qjzejbyk'],
    ];

}
