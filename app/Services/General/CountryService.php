<?php

namespace App\Services\General;

use App\Repositories\General\CountryRepository;
use App\Services\AbstractService;

class CountryService extends AbstractService
{
    protected $repo;
    public function __construct(CountryRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
