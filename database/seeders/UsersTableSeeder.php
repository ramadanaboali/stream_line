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
            "name"=> "super Admin",
            "type" => 'admin',
            "password" => bcrypt(config('admin.password'))
        ]);
    }
}
