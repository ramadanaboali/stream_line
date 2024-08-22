<?php

namespace App\Repositories\Vendor;

use App\Models\Package;
use App\Models\Subscription;
use App\Repositories\AbstractRepository;
use App\Services\ArbPg;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Subscription::class);
    }
    public function subscribe($data){
        $package=Package::withTrashed()->findOrFail($data['package_id']);
        $days=0;
        $price=0;
        switch($package->period){
            case 'days':
                $days=$package->days;
                $price=$package->days_price;
                break;
            case 'month':
                $days=30;
                $price=$package->month_price;
                break;
            case 'quarter':
                $days=90;
                $price=$package->quarter_price;
                break;
            case 'half_year':
                $days=180;
                $price=$package->half_year_price;
                break;
            case 'year':
                $days=360;
                $price=$package->year_price;
                break;
            default:
                $days=360;
                $price=0;
                break;
        }
        $subscription=Subscription::create([
            'auto_renew'=>$data['auto_renew'],
            'package_id'=>$data['package_id'],
            'vendor_id'=>$data['vendor_id'],
            'created_by'=>$data['created_by'],
            'period'=>$package->period,
            'subscription_type'=>$package->subscription_type,
            'days'=>$days,
            'price'=>$price,
            'name_ar'=>$package->name_ar,
            'commission'=>$package->commission,
            'sms_messages'=>$package->sms_messages,
            'whatsapp_messages'=>$package->whatsapp_messages,
            'branches'=>$package->branches,
            'employee'=>$package->employees,
            'customers'=>$package->customers,
            'payments'=>$package->payments,
            'remove_copy_right'=>$package->remove_copy_right,
            'status' => 'pending'
        ]);
        return $subscription;
    }
    public function pay($data){
        try {
            $subscription=Subscription::withTrashed()->findOrFail($data['subscription_id']);
            $arbPg = new ArbPg($subscription->id, $subscription->price);
            return $arbPg->getSubscriptionPaymentId();

        } catch (\Exception $e) {
        return  $e->getMessage();
        }
    }

}
