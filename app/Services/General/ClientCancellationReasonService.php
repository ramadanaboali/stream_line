<?php

namespace App\Services\General;

use App\Repositories\General\ClientCancellationReasonRepository;
use App\Services\AbstractService;

class ClientCancellationReasonService extends AbstractService
{
    protected $repo;
    public function __construct(ClientCancellationReasonRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
