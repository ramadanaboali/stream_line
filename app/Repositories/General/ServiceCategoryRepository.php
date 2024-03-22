<?php

namespace App\Repositories\General;

use App\Models\ServiceCategory;
use App\Repositories\AbstractRepository;

class ServiceCategoryRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(ServiceCategory::class);
    }


}
