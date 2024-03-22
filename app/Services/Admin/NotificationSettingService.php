<?php

namespace App\Services\Admin;

use App\Repositories\Admin\NotificationSettingRepository;
use App\Services\AbstractService;

class NotificationSettingService extends AbstractService
{
    protected $repo;
    public function __construct(NotificationSettingRepository $repo)
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
