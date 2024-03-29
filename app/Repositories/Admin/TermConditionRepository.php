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

    public function getSetting($user_id,$vendor)
    {
        if($vendor){
            $query = [
                'is_active' => '1',
                "vendor_id"=> $vendor->id,
            ];
        }else{
            $query = [
                'is_active' => '1',
                "is_system"=> '1',
            ];
        }
        $item=  TermCondition::firstOrCreate($query, [
            "content"=> "Term & Conditions",
            "created_by"=> $user_id,
        ]);
        return $item;
    }
    public function updateSetting($data,$user_id,$vendor)
        {
        if($vendor){
            $query = [
                'is_active' => '1',
                "vendor_id"=> $vendor->id,
            ];
        }else{
            $query = [
                'is_active' => '1',
                "is_system"=> '1',
            ];
        }
        $item= TermCondition::firstOrCreate($query, [
            "content"=> "Term & Conditions",
            "created_by"=> $user_id,
        ]);
        return $item->update($data);
    }


}
