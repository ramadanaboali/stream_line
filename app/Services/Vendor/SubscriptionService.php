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
        $data['vendor_id']= auth()->user()->vendor->id;
        return $this->repo->subscribe($data);
    }
    public function pay($data){
        return $this->repo->pay($data);
    }
    public function check_is_paid($data){
        return $this->repo->check_is_paid($data);
    }

  }
