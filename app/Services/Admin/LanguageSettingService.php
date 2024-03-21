<?php

namespace App\Services\Admin;

use App\Repositories\Admin\LanguageSettingRepository;
use App\Services\AbstractService;

class LanguageSettingService extends AbstractService
{
    protected $repo;
    public function __construct(LanguageSettingRepository $repo)
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
