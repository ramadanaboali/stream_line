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
        $user_id= auth()->user()->id;
        return $this->repo->getSetting($user_id);
    }
    public function updateSetting(array $data){
        $user_id= auth()->user()->id;
        return $this->repo->updateSetting($data,$user_id);
    }
}
