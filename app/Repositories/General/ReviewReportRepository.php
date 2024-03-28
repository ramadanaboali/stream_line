<?php

namespace App\Repositories\General;

use App\Models\ReviewReport;
use App\Repositories\AbstractRepository;

class ReviewReportRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(ReviewReport::class);
    }


}
