<?php

namespace App\Services\Admin;

use App\Repositories\Admin\BannerRepository;
use App\Services\AbstractService;

class BannerService extends AbstractService
{
    protected $repo;
    public function __construct(BannerRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
