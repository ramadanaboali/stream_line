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
            'is_active' => '1'
        ], [
            "content"=> "terms & conditions",
            "created_by"=> 1,
        ]);

    }
}
