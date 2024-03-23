<?php

namespace App\Repositories\Vendor;

use App\Models\User;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function createUser(array $data)
    {
        try {
            DB::beginTransaction();
            $inputs = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birthdate' => $data['birthdate'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'model_id' => auth()->user()->model_id,
            'country_id' => $data['country_id'],
            'region_id' => $data['region_id'],
            'city_id' => $data['city_id'],
            'image' => $data['image'],
            'type' => 'vendor',
            'password' => Hash::make($data['password']),
            'created_by'=> auth()->user()->id,

            ];

            $item = User::create($inputs);
            if($item) {
                $role = Role::find($data['role_id']);
                $item->assignRole($role->name);
            }
            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    public function updateUser($data,$item)
    {

        try {
            DB::beginTransaction();
            $inputs = [
            'first_name' => $data['first_name'] ?? $item->first_name,
            'last_name' => $data['last_name'] ?? $item->last_name,
            'birthdate' => $data['birthdate'] ?? $item->birthdate,
            'email' => $data['email'] ?? $item->email,
            'phone' => $data['phone'] ?? $item->phone,
            'country_id' => $data['country_id'] ?? $item->country_id,
            'region_id' => $data['region_id'] ?? $item->region_id,
            'city_id' => $data['city_id'] ?? $item->city_id,
            'image' => $data['image'] ?? $item->image,
            'password' => Hash::make($data['password'])?? $item->password,
            'updated_by'=> auth()->user()->id,

            ];
            $item->update($inputs);
            $role = Role::find($data['role_id']);
            $item->assignRole($role->name);
            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
