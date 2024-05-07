<?php

namespace App\Services\Admin;

use App\Repositories\Admin\HomeRepository;
use App\Services\AbstractService;

class HomeService extends AbstractService
{
    protected $repo;
    public function __construct(HomeRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function home_totals()
    {
        return $this->repo->home_totals();
    }
    public function booking_count_chart(array $data)
    {
        return $this->repo->booking_count_chart($data);
    }
    public function booking_total_chart(array $data)
    {
        return $this->repo->booking_total_chart($data);
    }
}
