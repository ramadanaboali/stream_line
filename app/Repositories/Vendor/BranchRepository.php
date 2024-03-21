<?php

namespace App\Repositories\Vendor;

use App\Models\Branch;
use App\Repositories\AbstractRepository;

class BranchRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Branch::class);
    }


}
