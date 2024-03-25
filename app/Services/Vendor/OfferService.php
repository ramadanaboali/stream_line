<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\OfferRepository;
use App\Services\AbstractService;

class OfferService extends AbstractService
{
    protected $repo;
    public function __construct(OfferRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }

}
