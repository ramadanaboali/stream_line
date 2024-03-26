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

    public function subscribe($data){

        $data['created_by']= auth()->user()->id;
        return $this->repo->subscribe($data);
    }
    public function pay($data){
        return $this->repo->pay($data);
    }

  }
