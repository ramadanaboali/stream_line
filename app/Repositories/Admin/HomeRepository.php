<?php

namespace App\Repositories\Admin;

use App\Models\Booking;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vendor;
use App\Repositories\AbstractRepository;

class HomeRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function home_totals()
    {
        $data=[];
        $data['subscription_count'] = Subscription::where('status','!=','pending')->count();
        $data['subscription_total'] = Subscription::where('status','!=','pending')->sum('price');
        $data['booking_count'] = Booking::where('status','!=','canceled')->count();
        $data['booking_total'] = Booking::where('status','!=','canceled')->sum('total');
        $data['customer_count'] = User::where('users.type','=','customer')->count();
        $data['vendor_count'] = Vendor::where('is_active','=','1')->count();
        return $data;
    }
    public function booking_count_chart(array $data)
    {
        return $data;
    }
    public function booking_total_chart(array $data)
    {
        return $data;
    }

}
