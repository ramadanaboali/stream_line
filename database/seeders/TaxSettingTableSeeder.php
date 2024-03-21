<?php

namespace Database\Seeders;

use App\Models\ServiceSetting;
use Illuminate\Database\Seeder;

class TaxSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceSetting::firstOrCreate([
            'is_active' => '1'
        ], [
            "tax_percentage"=> 0,
            "created_by"=> 1,
        ]);

    }
}
