<?php

namespace App\Repositories\General;

use App\Models\CancellationReason;
use App\Repositories\AbstractRepository;

class CancellationReasonRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(CancellationReason::class);
    }


}
