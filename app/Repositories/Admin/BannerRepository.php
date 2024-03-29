<?php

namespace App\Repositories\Admin;

use App\Models\Banner;
use App\Repositories\AbstractRepository;

class BannerRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Banner::class);
    }


}
