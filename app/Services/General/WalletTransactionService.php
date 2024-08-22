<?php

namespace App\Services\General;

use App\Repositories\General\WalletTransactionRepository;
use App\Services\AbstractService;

class WalletTransactionService extends AbstractService
{
    protected $repo;
    public function __construct(WalletTransactionRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function storeTransaction($data){

        $data['created_by']= auth()->user()->id;
        return $this->repo->storeTransaction($data);
    }
}
