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
            'is_active' => '1',
            "user_id"=> 1,
        ], [
            "default"=> "ar",
            "user_id"=> 1,
            "created_by"=> 1,
        ]);

    }
}
