<?php

namespace Database\Seeders;

use App\Models\LanguageSetting;
use Illuminate\Database\Seeder;

class LanguageSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LanguageSetting::firstOrCreate([
            'is_active' => '1'
        ], [
            "default"=> "en",
            "created_by"=> 1,
        ]);

    }
}
