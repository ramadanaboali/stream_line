<?php

namespace App\Repositories\Vendor;

use App\Models\Subscription;
use App\Repositories\AbstractRepository;
class SubscriptionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Subscription::class);
    }

}
