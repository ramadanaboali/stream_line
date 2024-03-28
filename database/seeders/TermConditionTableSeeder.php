<?php

namespace Database\Seeders;

use App\Models\TermCondition;
use Illuminate\Database\Seeder;

class TermConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TermCondition::firstOrCreate([
            'is_active' => '1',
            'is_system' => '1'
        ], [
            "content"=> "terms & conditions",
            "created_by"=> 1,
        ]);

    }
}
