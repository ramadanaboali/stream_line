<?php

namespace App\Repositories\General;

use App\Models\WalletTransaction;
use App\Repositories\AbstractRepository;

class WalletTransactionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(WalletTransaction::class);
    }


}
