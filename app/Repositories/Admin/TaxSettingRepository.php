<?php

namespace App\Repositories\Admin;

use App\Models\TaxSetting;
use App\Repositories\AbstractRepository;

class TaxSettingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(TaxSetting::class);
    }

    public function getSetting()
    {
        return TaxSetting::where('is_active', '1')->firstOrFail();
    }
    public function updateSetting($data)
    {
        $item=TaxSetting::where('is_active', '1')->firstOrFail();
        return $item->update($data);
    }


}
