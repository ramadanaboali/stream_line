<?php

namespace App\Repositories\Vendor;

use App\Models\User;
use App\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }


}
