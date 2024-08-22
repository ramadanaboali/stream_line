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
        $user_id= auth()->user()->id;
        $vendor= auth()->user()->vendor;
        return $this->repo->getSetting($user_id,$vendor);
    }
    public function updateSetting(array $data){
        $user_id= auth()->user()->id;
        $vendor= auth()->user()->vendor;
        return $this->repo->updateSetting($data,$user_id,$vendor);
    }
}
