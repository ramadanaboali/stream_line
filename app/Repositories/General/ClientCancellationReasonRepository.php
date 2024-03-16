<?php

namespace App\Repositories\General;

use App\Models\ClientCancellationReason;
use App\Repositories\AbstractRepository;

class ClientCancellationReasonRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(ClientCancellationReason::class);
    }


}
