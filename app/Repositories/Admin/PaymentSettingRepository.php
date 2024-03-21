<?php

namespace App\Repositories\Admin;

use App\Models\PaymentSetting;
use App\Repositories\AbstractRepository;

class PaymentSettingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(PaymentSetting::class);
    }

    public function getSetting()
    {
        return PaymentSetting::where('is_active', '1')->firstOrFail();
    }
    public function updateSetting($data)
    {
        $item=PaymentSetting::where('is_active', '1')->firstOrFail();
        return $item->update($data);
    }


}
