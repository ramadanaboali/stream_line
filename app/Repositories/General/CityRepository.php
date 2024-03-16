<?php

namespace App\Repositories\General;

use App\Models\City;
use App\Repositories\AbstractRepository;

class CityRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(City::class);
    }


}
