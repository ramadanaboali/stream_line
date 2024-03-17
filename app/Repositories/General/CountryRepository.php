<?php

namespace App\Repositories\General;

use App\Models\Country;
use App\Repositories\AbstractRepository;

class CountryRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Country::class);
    }


}
