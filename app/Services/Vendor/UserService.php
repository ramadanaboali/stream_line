<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\UserRepository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService extends AbstractService
{
    protected $repo;
    public function __construct(UserRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function store($data){
        try{

            DB::beginTransaction();
            $inputs = [
            'first_name'=>$data['first_name'],
            'last_name'=>$data['last_name'],
            'birthdate'=>$data['birthdate'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'country_id'=>$data['country_id'],
            'region_id'=>$data['region_id'],
            'city_id'=>$data['city_id'],
            'image'=>$data['image'],
            'password'=>Hash::make($data['password']),
            ];

            $user = $this->repo->create($inputs);
            if($user){
                $role=Role::find($data['role_id']);
                $user->assignRole($role->name);
                // $user->branches()->attach($data['branch_id']);
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
