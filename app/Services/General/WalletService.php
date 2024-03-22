<?php

namespace App\Services\General;

use App\Repositories\General\WalletRepository;
use App\Services\AbstractService;

class WalletService extends AbstractService
{
    protected $repo;
    public function __construct(WalletRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
