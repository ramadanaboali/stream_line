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
        $item=  PrivacyPolicy::firstOrCreate($query, [
            "content"=> "Privacy & Policy",
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
        $item= PrivacyPolicy::firstOrCreate($query, [
            "content"=> "Privacy & Policy",
            "created_by"=> $user_id,
        ]);
        return $item->update($data);
    }


}
