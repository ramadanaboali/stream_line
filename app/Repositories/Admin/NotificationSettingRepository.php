<?php

namespace App\Repositories\Admin;

use App\Models\NotificationSetting;
use App\Repositories\AbstractRepository;

class NotificationSettingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(NotificationSetting::class);
    }

    public function getSetting()
    {
        return NotificationSetting::where('is_active', '1')->firstOrFail();
    }
    public function updateSetting($data)
    {
        $item=NotificationSetting::where('is_active', '1')->firstOrFail();
        return $item->update($data);
    }


}
