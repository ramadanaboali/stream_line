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

    public function getSetting()
    {
        return LanguageSetting::where('is_active', '1')->firstOrFail();
    }
    public function updateSetting($data)
    {
        $item=LanguageSetting::where('is_active', '1')->firstOrFail();
        return $item->update($data);
    }


}
