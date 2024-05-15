<?php

namespace App\Repositories\Admin;

use App\Models\Booking;
use App\Models\Offer;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vendor;
use App\Repositories\AbstractRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $data['offer_count'] = Offer::where('is_active','!=','1')->count();
        $data['booking_total'] = Booking::where('status','!=','canceled')->sum('total');
        $data['customer_count'] = User::where('users.type','=','customer')->count();
        $data['vendor_count'] = Vendor::where('is_active','=','1')->count();
        return $data;
    }
    public function booking_count_chart(array $data)
    {
        $filter = array_key_exists('filter',$data) ? $data['filter'] : 'day';
        $currentDateTime = Carbon::now();
        $currentYear = $currentDateTime->year;
        $currentMonth = $currentDateTime->month;
        $currentWeek = $currentDateTime->weekOfYear;
        $currentDate = $currentDateTime->toDateString();
        return match ($filter) {
            'all' => Booking::select(DB::raw('YEAR(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->groupBy('x_key')
                ->get(),
            'year' => Booking::select(DB::raw('MONTH(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->groupBy('x_key')
                ->get(),
            'month' => Booking::select(DB::raw('DAY(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->groupBy('x_key')
                ->get(),
            'week' => Booking::select(DB::raw('DAYOFWEEK(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->groupBy('x_key')
                ->get(),
            default => Booking::select(DB::raw('HOUR(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->whereDate('created_at', $currentDate)
                ->groupBy('x_key')
                ->get(),
        };
    }
    public function booking_total_chart(array $data)
    {
        $filter = array_key_exists('filter',$data) ? $data['filter'] : 'day';
        $currentDateTime = Carbon::now();
        $currentYear = $currentDateTime->year;
        $currentMonth = $currentDateTime->month;
        $currentWeek = $currentDateTime->weekOfYear;
        $currentDate = $currentDateTime->toDateString();
        return match ($filter) {
            'all' => Booking::select(DB::raw('YEAR(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->groupBy('x_key')
                ->get(),
            'year' => Booking::select(DB::raw('MONTH(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->groupBy('x_key')
                ->get(),
            'month' => Booking::select(DB::raw('DAY(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->groupBy('x_key')
                ->get(),
            'week' => Booking::select(DB::raw('DAYOFWEEK(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->groupBy('x_key')
                ->get(),
            default => Booking::select(DB::raw('HOUR(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->whereDate('created_at', $currentDate)
                ->groupBy('x_key')
                ->get(),
        };
    }



    public function booking_count_with_month_chart(array $data)
    {
        $year = array_key_exists('year',$data) ? $data['year'] : '2024';

        return Booking::select(DB::raw('MONTH(created_at) as x_key'), DB::raw('COUNT(id) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('x_key')
            ->get();
    }
    public function register_count_with_month_chart(array $data)
    {
        $year = array_key_exists('year',$data) ? $data['year'] : '2024';

        return Vendor::select(DB::raw('MONTH(created_at) as x_key'), DB::raw('COUNT(id) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('x_key')
            ->get();
    }

    public function booking_count_last_week_chart(array $data)
    {
        $currentDateTime = Carbon::now();
        $currentYear = $currentDateTime->year;
        $currentMonth = $currentDateTime->month;
        $currentWeek = $currentDateTime->weekOfYear;
        return Booking::select(DB::raw('DAYOFWEEK(created_at) as x_key'), DB::raw('COUNT(id) as count'))
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
            ->groupBy('x_key')
            ->get();
    }

    public function last_bookings()
    {
        return Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->orderBy('id','desc')
            ->limit(10)
            ->get();
    }
    public function last_customers()
    {
        return User::select('users.*')->with(['bookings','reviews'])
            ->where('users.type','=','customer')
            ->orderBy('id','desc')
            ->limit(10)
            ->get();
    }

}
