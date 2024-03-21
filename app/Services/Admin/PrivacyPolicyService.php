<?php

namespace App\Services\Admin;

use App\Repositories\Admin\PrivacyPolicyRepository;
use App\Services\AbstractService;

class PrivacyPolicyService extends AbstractService
{
    protected $repo;
    public function __construct(PrivacyPolicyRepository $repo)
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
