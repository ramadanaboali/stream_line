<?php

namespace App\Repositories\General;

use App\Models\Review;
use App\Repositories\AbstractRepository;

class ReviewRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Review::class);
    }


}
