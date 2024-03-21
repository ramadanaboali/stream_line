<?php

namespace App\Repositories\Admin;

use App\Models\TermCondition;
use App\Repositories\AbstractRepository;

class TermConditionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(TermCondition::class);
    }

    public function getSetting()
    {
        return TermCondition::where('is_active', '1')->firstOrFail();
    }
    public function updateSetting($data)
    {
        $item=TermCondition::where('is_active', '1')->firstOrFail();
        return $item->update($data);
    }


}
