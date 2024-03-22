<?php

namespace App\Services\Admin;

use App\Repositories\Admin\HelpCenterRepository;
use App\Services\AbstractService;

class HelpCenterService extends AbstractService
{
    protected $repo;
    public function __construct(HelpCenterRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
