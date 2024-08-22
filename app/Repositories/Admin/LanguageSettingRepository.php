<?php

namespace App\Repositories\Admin;

use App\Models\LanguageSetting;
use App\Repositories\AbstractRepository;

class LanguageSettingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(LanguageSetting::class);
    }

    public function getSetting($user_id)
    {
        return  LanguageSetting::firstOrCreate([
            'is_active' => '1',
            "user_id"=> $user_id,
        ], [
            "default"=> "ar",
            "user_id"=> $user_id,
            "created_by"=> $user_id,
        ]);
    }
    public function updateSetting($data,$user_id)
    {
        $item= LanguageSetting::firstOrCreate([
            'is_active' => '1',
            "user_id"=> $user_id,
        ], [
            "default"=> "ar",
            "user_id"=> $user_id,
            "created_by"=> $user_id,
        ]);
        return $item->update($data);
    }


}
