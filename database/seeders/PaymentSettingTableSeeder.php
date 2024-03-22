<?php

namespace Database\Seeders;

use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentSetting::firstOrCreate([
            'is_active' => '1'
        ], [
            "online_payment"=> '1',
            "online_on_delivery_payment"=> '1',
            "created_by"=> 1,
        ]);

    }
}
