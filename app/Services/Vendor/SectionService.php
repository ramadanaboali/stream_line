<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\SectionRepository;
use App\Services\AbstractService;
class SectionService extends AbstractService
{
    protected $repo;
    public function __construct(SectionRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
  }
