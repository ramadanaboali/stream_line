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
  }
