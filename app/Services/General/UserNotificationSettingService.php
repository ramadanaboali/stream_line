<?php

namespace App\Services\General;

use App\Repositories\General\UserNotificationSettingRepository;
use App\Services\AbstractService;

class UserNotificationSettingService extends AbstractService
{
    protected $repo;
    public function __construct(UserNotificationSettingRepository $repo)
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
