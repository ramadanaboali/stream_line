<?php

namespace App\Services;

use App\Models\Unit;
use App\Repositories\UnitRepository;

class UnitService extends AbstractService
{
    protected $repo;
    public function __construct(UnitRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
