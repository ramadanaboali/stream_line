<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Seeder;

class PrivacyPolicyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrivacyPolicy::firstOrCreate([
            'is_active' => '1',
            'is_system' => '1'
        ], [
            "content"=> "Privacy & polices",
            "created_by"=> 1,
        ]);

    }
}
