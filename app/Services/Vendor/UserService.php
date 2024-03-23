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
    public function createUser($data){
        try{
            return $this->repo->createUser($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateUser($data,$item){
        try{
            return $this->repo->updateUser($data, $item);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
