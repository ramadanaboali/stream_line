<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\SubscriptionRepository;
use App\Services\AbstractService;
class SubscriptionService extends AbstractService
{
    protected $repo;
    public function __construct(SubscriptionRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
  }
