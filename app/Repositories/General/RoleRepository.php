<?php

namespace App\Repositories\General;


use Spatie\Permission\Models\Role;
use App\Repositories\AbstractRepository;

class RoleRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Role::class);
    }


}
