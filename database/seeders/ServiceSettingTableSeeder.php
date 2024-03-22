<?php

namespace Database\Seeders;

use App\Models\ServiceSetting;
use Illuminate\Database\Seeder;

class ServiceSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceSetting::firstOrCreate([
            'is_active' => '1'
        ], [
            "difference_in_min"=> 15,
            "created_by"=> 1,
        ]);

    }
}
