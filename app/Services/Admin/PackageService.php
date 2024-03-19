<?php

namespace App\Services\Admin;

use App\Repositories\Admin\PackageRepository;
use App\Services\AbstractService;

class PackageService extends AbstractService
{
    protected $repo;
    public function __construct(PackageRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
