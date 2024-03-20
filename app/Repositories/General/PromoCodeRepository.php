<?php

namespace App\Repositories\General;

use App\Models\PromoCode;
use App\Repositories\AbstractRepository;

class PromoCodeRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(PromoCode::class);
    }


}
