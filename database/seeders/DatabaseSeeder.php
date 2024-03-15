<?php
namespace database\seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
//         $this->call(UsersTableSeeder::class);
    }
}
