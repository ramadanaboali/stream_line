<?php

namespace App\Services\General;

use App\Repositories\General\CityRepository;
use App\Services\AbstractService;

class CityService extends AbstractService
{
    protected $repo;
    public function __construct(CityRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
