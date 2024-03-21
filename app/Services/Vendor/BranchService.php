<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\BranchRepository;
use App\Services\AbstractService;

class BranchService extends AbstractService
{
    protected $repo;
    public function __construct(BranchRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
