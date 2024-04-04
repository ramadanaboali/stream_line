<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    protected $auth;
    protected $response;

    public function __construct(Guard $auth, ResponseFactory $response)
    {
        $this->auth = $auth;
        $this->response = $response;
    }

    public function handle($request, Closure $next, $feature)
    {
        $user=auth()->user;
        switch ($feature) {
            case 'branches':
                return $this->checkBranches($request,$next,$user);
                break;
            case 'employees':
                return $this->checkEmployees($request,$next,$user);
                break;
            default:
                return $next($request);
                break;
        }

        return apiResponse(false, null, 'Your Subscription has reached the limits of '.$feature, null, 403);
    }
    public function checkBranches($request, Closure $next,User $user){
        $vendor=$user->vendor();
        if($vendor){
            $activeSubscription=Subscription::where('vendor_id',$vendor->id)->where('status','active')->where('end_date' ,'>=',Carbon::now()->toDateString())->first();
            if(!$activeSubscription){
                return apiResponse(false, null, 'You Do not have active subscription ', null, 403);

            }
            $branches=Branch::where('vendor_id',$vendor->id)->count();
            if($branches >= $activeSubscription->branches){
                return apiResponse(false, null, 'Your Subscription has reached the limits of number of branches at this package', null, 403);
            }
        }
            return $next($request);
    }
    public function checkEmployees($request, Closure $next,User $user){
        $vendor=$user->vendor();
        if($vendor){
            $activeSubscription=Subscription::where('vendor_id',$vendor->id)->where('status','active')->where('end_date' ,'>=',Carbon::now()->toDateString())->first();
            if(!$activeSubscription){
                return apiResponse(false, null, 'You Do not have active subscription ', null, 403);

            }
            $employees=Employee::where('vendor_id',$vendor->id)->count();
            if($employees >= $activeSubscription->employees){
                return apiResponse(false, null, 'Your Subscription has reached the limits of number of employees at this package', null, 403);
            }
        }
        return $next($request);
    }
}
