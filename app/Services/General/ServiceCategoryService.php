<?php

namespace App\Services\General;

use App\Repositories\General\ServiceCategoryRepository;
use App\Services\AbstractService;

class ServiceCategoryService extends AbstractService
{
    protected $repo;
    public function __construct(ServiceCategoryRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
