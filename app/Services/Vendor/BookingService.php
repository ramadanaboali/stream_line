<?php

namespace App\Services\Vendor;

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
    public function cancel($id){
        return $this->repo->cancel($id);
    }
  }
