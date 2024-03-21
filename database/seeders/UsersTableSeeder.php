<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            "email"=> config('admin.email')
        ], [
            "phone"=> config('admin.phone'),
            "first_name"=> "super",
            "last_name"=> "Admin",
            "type" => 'admin',
            "password" => bcrypt(config('admin.password'))
        ]);
        $countries=[
            'name_ar'=>'السعودية',
            'name_en'=>'Saudia Arabia',
            'code'=>'+996',
            'is_active'=>'1'
        ];
        $country=Country::firstOrCreate(['is_active' => '1'],$countries);
        $regions=[
            'name_ar'=>'منطقة الرياض',
            'name_en'=>'Ryadh Region',
            'country_id'=>$country->id,
            'is_active'=>'1'
        ];
        $region=Region::firstOrCreate(['is_active' => '1'],$regions);
        $cities=[
            'name_ar'=>'الرياض',
            'region_id'=>$region->id,
            'name_en'=>'Ryadh',
            'is_active'=> '1'
        ];
        City::firstOrCreate(['is_active' => '1'],$cities);
    }
}
