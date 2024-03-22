<?php

namespace database\seeders;

use Database\Seeders\UsersTableSeeder;
use Database\Seeders\PaymentSettingTableSeeder;
use Database\Seeders\ServiceSettingTableSeeder;
use Database\Seeders\TaxSettingTableSeeder;
use Database\Seeders\NotificationSettingTableSeeder;
use Database\Seeders\TermConditionTableSeeder;
use Database\Seeders\PrivacyPolicyTableSeeder;
use Database\Seeders\LanguageSettingTableSeeder;
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
        $this->call(NotificationSettingTableSeeder::class);
        $this->call(TermConditionTableSeeder::class);
        $this->call(PrivacyPolicyTableSeeder::class);
        $this->call(LanguageSettingTableSeeder::class);
    }
}
