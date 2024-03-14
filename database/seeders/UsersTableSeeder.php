<?php

namespace database\seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::updateOrCreate([
            "email"=> config('admin.email')
        ], [
            "phone"=> config('admin.phone'),
            "full_name"=> "سوبر أدمن",
            "full_name_latin"=> "super Admin",
            "password" => bcrypt(config('admin.password'))
        ]);
    }
}
