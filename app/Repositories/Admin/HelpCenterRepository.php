<?php

namespace App\Repositories\Admin;

use App\Models\HelpCenter;
use App\Repositories\AbstractRepository;

class HelpCenterRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(HelpCenter::class);
    }


}
