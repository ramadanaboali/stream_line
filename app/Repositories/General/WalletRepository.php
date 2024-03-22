<?php

namespace App\Repositories\General;

use App\Models\Wallet;
use App\Repositories\AbstractRepository;

class WalletRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Wallet::class);
    }


}
