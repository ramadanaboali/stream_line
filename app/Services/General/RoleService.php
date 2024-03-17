<?php

namespace App\Services\General;

use App\Repositories\General\RoleRepository;
use App\Services\AbstractService;

class RoleService extends AbstractService
{
    protected $repo;
    public function __construct(RoleRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function store($data){
        $roleData =  ['display_name' => $data['display_name'], 'name' => $data['name']];
        $item = $this->repo->create($roleData);
        return $item->syncPermissions($data['permissions']);

    }
    public function update($data, $role){
        $role->syncPermissions($data['permissions']);
        return $role->update($data);
    }
}
