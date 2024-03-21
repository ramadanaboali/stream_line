<?php

namespace App\Services\General;

use App\Repositories\General\CancellationReasonRepository;
use App\Services\AbstractService;

class CancellationReasonService extends AbstractService
{
    protected $repo;
    public function __construct(CancellationReasonRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
