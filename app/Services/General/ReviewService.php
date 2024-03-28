<?php

namespace App\Services\General;

use App\Repositories\General\ReviewRepository;
use App\Services\AbstractService;

class ReviewService extends AbstractService
{
    protected $repo;
    public function __construct(ReviewRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
