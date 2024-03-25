<?php

namespace App\Repositories\Vendor;

use App\Models\Package;
use App\Models\Subscription;
use App\Repositories\AbstractRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Subscription::class);
    }
    public function subscribe($data){
        $package=Package::findOrFail($data['package_id']);
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
            'user_id'=>$data['user_id'],
            'created_by'=>$data['created_by'],
            'period'=>$package->period,
            'subscription_type'=>$package->subscription_type,
            'days'=>$days,
            'price'=>$price,
            'commission'=>$package->commission,
            'sms_messages'=>$package->sms_messages,
            'whatsapp_messages'=>$package->whatsapp_messages,
            'status' => 'pending'
        ]);
        return $subscription;
    }
    public function pay($data){
        $subscription=Subscription::findOrFail($data['subscription_id']);
        $today =Carbon::now();
        $activeSubscription=Subscription::where('user_id',$subscription->user_id)->where('status','active')->first();
        DB::beginTransaction();
        try {
            if(!$activeSubscription){
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days)->toDateString();
                $subscription->status='active';
                $subscription->save();
            } else if( $activeSubscription->end_date <= $today->toDateString()){
                $activeSubscription->status='finished';
                $activeSubscription->save();
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days)->toDateString();
                $subscription->status='active';
                $subscription->save();
            }else if($activeSubscription->package_id != $subscription->package_id){
                $activeSubscription->status='cancelled';
                $activeSubscription->save();
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days)->toDateString();
                $subscription->status='active';
                $subscription->save();
            }else{
                $activeSubscription->status='expanded';
                $activeSubscription->save();
                $diffInDays = Carbon::today()->diffInDays(Carbon::parse($activeSubscription->end_date));
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days+$diffInDays)->toDateString();
                $subscription->status='active';
                $subscription->save();
            }

            DB::commit();
            return $subscription;
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }

    }

}
