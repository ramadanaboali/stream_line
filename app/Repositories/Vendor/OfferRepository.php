<?php

namespace App\Repositories\Vendor;

use App\Models\Offer;
use App\Repositories\AbstractRepository;
use App\Services\General\StorageService;

class OfferRepository extends AbstractRepository
{
    protected StorageService $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
        parent::__construct(Offer::class);
    }


}
