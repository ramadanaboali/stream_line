<?php

namespace App\Services\Admin;

use App\Repositories\Admin\TermConditionRepository;
use App\Services\AbstractService;

class TermConditionService extends AbstractService
{
    protected $repo;
    public function __construct(TermConditionRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }

    public function getSetting(){
        return $this->repo->getSetting();
    }
    public function updateSetting(array $data){
        return $this->repo->updateSetting($data);
    }
}
