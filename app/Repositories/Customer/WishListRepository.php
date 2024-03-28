<?php

namespace App\Repositories\Customer;

use App\Models\WishList;
use App\Repositories\AbstractRepository;

class WishListRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(WishList::class);
    }


}
