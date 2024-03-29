<?php

namespace App\Repositories\Vendor;

use App\Models\VendorSetting;
use App\Repositories\AbstractRepository;
class VendorSettingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(VendorSetting::class);
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
        $item=  VendorSetting::firstOrCreate($query, [
            "stock_alert"=> 1,
            "calender_differance"=> 10,
            "booking_differance"=> 1,
            "cancel_booking"=> 1,
            "reschedule_booking"=> 1,
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
        $item= VendorSetting::firstOrCreate($query, [
            "stock_alert"=> 1,
            "calender_differance"=> 10,
            "booking_differance"=> 1,
            "cancel_booking"=> 1,
            "reschedule_booking"=> 1,
            "created_by"=> $user_id,
        ]);
        return $item->update($data);
    }

}
