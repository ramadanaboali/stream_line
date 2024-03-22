<?php

namespace App\Services\General;

use App\Repositories\General\RegionRepository;
use App\Services\AbstractService;

class RegionService extends AbstractService
{
    protected $repo;
    public function __construct(RegionRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
