<?php

namespace App\Repositories\Admin;

use App\Models\ServiceSetting;
use App\Repositories\AbstractRepository;

class ServiceSettingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(ServiceSetting::class);
    }

    public function getSetting()
    {
        return ServiceSetting::where('is_active', '1')->firstOrFail();
    }
    public function updateSetting($data)
    {
        $item=ServiceSetting::where('is_active', '1')->firstOrFail();
        return $item->update($data);
    }


}
