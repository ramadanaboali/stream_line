<?php

namespace App\Repositories\General;

use App\Models\Region;
use App\Repositories\AbstractRepository;

class RegionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Region::class);
    }


}
