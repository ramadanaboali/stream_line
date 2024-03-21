<?php

namespace database\seeders;

use Database\Seeders\UsersTableSeeder;
use Database\Seeders\PaymentSettingTableSeeder;
use Database\Seeders\ServiceSettingTableSeeder;
use Database\Seeders\TaxSettingTableSeeder;
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
        $this->call(UsersTableSeeder::class);
        $this->call(PaymentSettingTableSeeder::class);
        $this->call(ServiceSettingTableSeeder::class);
        $this->call(TaxSettingTableSeeder::class);

    }
}
