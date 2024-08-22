<?php

namespace App\Services\Customer;

use App\Repositories\Vendor\BookingRepository;
use App\Services\AbstractService;
class BookingService extends AbstractService
{
    protected $repo;
    public function __construct(BookingRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function createItem($data){
        return $this->repo->createItem($data);
    }
    public function pay($data){
        return $this->repo->pay($data);
    }
    public function promocode($code){
        return $this->repo->promocode($code);
    }
    public function cancel($id){
        return $this->repo->cancel($id);
    }
  }
