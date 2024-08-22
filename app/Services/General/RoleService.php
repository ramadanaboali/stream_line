<?php

namespace App\Services\General;

use App\Repositories\General\RoleRepository;
use App\Services\AbstractService;
use Spatie\Permission\Models\Permission;

class RoleService extends AbstractService
{
    protected $repo;
    public function __construct(RoleRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function store($data){


        $roleData =  ['display_name' => $data['display_name'], 'name' => $data['name'],'guard_name'=>$data['guard_name'],'model_type'=>$data['model_type']];
        $item = $this->repo->create($roleData);

        if (isset($data['permissions']) && is_array($data['permissions']) && count($data['permissions']) > 0) {

            $item->syncPermissions(Permission::whereIn('id', $data['permissions'])->get());
        }

        return $item;

    }
    public function update($data, $role){

        if (isset($data['permissions']) && is_array($data['permissions']) && count($data['permissions']) > 0) {

            $role->syncPermissions(Permission::whereIn('id', $data['permissions'])->get());
        }

        return $role->update($data);
    }
}
