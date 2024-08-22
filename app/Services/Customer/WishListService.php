<?php

namespace App\Services\Customer;

use App\Repositories\Customer\WishListRepository;
use App\Services\AbstractService;
class WishListService extends AbstractService
{
    protected $repo;
    public function __construct(WishListRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
  }
