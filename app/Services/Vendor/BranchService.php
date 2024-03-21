<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\BranchRepository;
use App\Services\AbstractService;

class BranchService extends AbstractService
{
    protected $repo;
    public function __construct(BranchRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function addImages($files,$id){
        $this->repo->addImages($files,$id);
    }
    public function officialHours($officialHours,$id){
        $this->repo->officialHours($officialHours,$id);
    }
}
