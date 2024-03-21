<?php

namespace App\Repositories\Admin;

use App\Models\PrivacyPolicy;
use App\Repositories\AbstractRepository;

class PrivacyPolicyRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(PrivacyPolicy::class);
    }

    public function getSetting()
    {
        return PrivacyPolicy::where('is_active', '1')->firstOrFail();
    }
    public function updateSetting($data)
    {
        $item=PrivacyPolicy::where('is_active', '1')->firstOrFail();
        return $item->update($data);
    }


}
