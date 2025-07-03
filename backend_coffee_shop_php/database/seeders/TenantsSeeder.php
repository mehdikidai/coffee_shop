<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ['name' => 'bee coffee','domain' => 'app1.kidai.site','db_name' => 'coffee_shop','tenant_token' => 'o7k6w328gip1'],
        ['name' => 'bee coffee 2','domain' => 'app2.kidai.site','db_name' => 'coffee_shop_2','tenant_token' => 'b6q68e469dif'],
        ['name' => 'bee coffee  3','domain' => '127.0.0.1','db_name' => 'coffee_shop_2','tenant_token' => 'k703qjzejbyk'],
    ];

}
