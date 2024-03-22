<?php

namespace Database\Seeders;

use App\Models\ServiceSetting;
use App\Models\TaxSetting;
use Illuminate\Database\Seeder;

class TaxSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaxSetting::firstOrCreate([
            'is_active' => '1'
        ], [
            "tax_percentage"=> 0,
            "created_by"=> 1,
        ]);

    }
}
