<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Seeder;

class NotificationSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationSetting::firstOrCreate([
            'is_active' => '1'
        ], [
            "email"=> '1',
            "sms"=> '1',
            "whatsapp"=> '1',
            "created_by"=> 1,
        ]);

    }
}
