<?php

namespace App\Repositories\General;

use App\Models\UserNotificationSetting;
use App\Repositories\AbstractRepository;

class UserNotificationSettingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(UserNotificationSetting::class);
    }
    public function getSetting($user_id)
    {
        $item=  UserNotificationSetting::firstOrCreate([
            'is_active' => '1',
            "created_by"=> $user_id
        ], [
            "email"=> '1',
            "sms"=> '1',
            "whatsapp"=> '1'
        ]);
        return $item;
    }
    public function updateSetting($data,$user_id)
    {
        $item=  UserNotificationSetting::firstOrCreate([
            'is_active' => '1',
            "created_by"=> $user_id
        ], [
            "email"=> '1',
            "sms"=> '1',
            "whatsapp"=> '1'
        ]);
        return $item->update($data);
    }


}
