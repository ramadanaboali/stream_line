<?php

namespace App\Repositories\Admin;

use App\Models\Package;
use App\Repositories\AbstractRepository;

class PackageRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Package::class);
    }


}
