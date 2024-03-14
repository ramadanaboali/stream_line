<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Models\User;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UnitRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Unit::class);
    }


}
