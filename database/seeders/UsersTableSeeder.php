<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Country;
use App\Models\Region;
use App\Models\Category;
use App\Models\City;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
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
            'is_active'=>1
        ];
        $country=Country::create($countries);
        $regions=[
            'name_ar'=>'منطقة الرياض',
            'name_en'=>'Ryadh Region',
            'country_id'=>$country->id,
            'is_active'=>1
        ];
        $region=Region::create($regions);
        $cities=[
            'name_ar'=>'الرياض',
            'region_id'=>$region->id,
            'name_en'=>'Ryadh',
            'is_active'=>1
        ];
        City::create($cities);
        $categories=[
            'name_ar'=>'قص شعر',
            'name_en'=>'cutting hair',
            'is_active'=>1
        ];
        Category::create($categories);
    }
}
