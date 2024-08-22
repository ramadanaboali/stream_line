<?php

namespace App\Services\General;

use App\Repositories\General\ReviewReportRepository;
use App\Services\AbstractService;

class ReviewReportService extends AbstractService
{
    protected $repo;
    public function __construct(ReviewReportRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
