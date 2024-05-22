<?php

namespace App\Repositories\Vendor;

use App\Models\Booking;
use App\Models\Service;
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
    public function customer_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = User::select('users.*')->whereHas('bookings', function ($query) use ($input) {
            $query->where('vendor_id','=',$input['vendor_id']);
        })->with(['bookings'=> function ($query) use($input) {
                $query->where('vendor_id','=',$input['vendor_id']);
            },'bookings.reviews','reviews'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('users.first_name', 'like', '%'.$input['search'].'%');
                $query->orWhere('users.last_name', 'like', '%'.$input['search'].'%');
            })->where('users.type','=','customer');
        return $list->paginate($itemPerPage);
    }
    public function customer_report_show($id,$input)
    {
        return User::select('users.*')->with(['bookings' => function ($query) use($input) {
            $query->where('vendor_id','=',$input['vendor_id']);
        },'bookings.reviews','reviews'])
            ->find($id);

    }

    public function service_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Service::select('services.*')->with(['category','section','employees','branches','vendor','vendor.user'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('services.name_ar', 'like', '%'.$input['search'].'%');
                $query->orWhere('services.name_ar', 'like', '%'.$input['search'].'%');
            })->where('services.vendor_id','=',$input['vendor_id']);
        return $list->paginate($itemPerPage);
    }
    public function service_report_show($id)
    {
        return Service::select('services.*')->with(['category','section','employees','branches','vendor','vendor.user'])
            ->find($id);
    }
    public function offer_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Offer::select('offers.*')->with(['services','section','category','sub_category','vendor','vendor.user'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('services.name_ar', 'like', '%'.$input['search'].'%');
                $query->orWhere('services.name_ar', 'like', '%'.$input['search'].'%');
            })->where('offers.vendor_id','=',$input['vendor_id']);
        return $list->paginate($itemPerPage);
    }
    public function offer_report_show($id)
    {
        return Offer::select('offers.*')->with(['services','section','category','sub_category','vendor','vendor.user'])
            ->find($id);
    }
    public function booking_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('services.payment_status', 'like', '%'.$input['search'].'%');
                $query->orWhere('services.payment_status', 'like', '%'.$input['search'].'%');
            })->where('bookings.vendor_id','=',$input['vendor_id']);
        return $list->paginate($itemPerPage);
    }
    public function booking_report_show($id)
    {
        return Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->find($id);
    }
    public function home_totals($input)
    {
        $data=[];
        $data['booking_count'] = Booking::where('status','!=','canceled')->where('vendor_id','=',$input['vendor_id'])->count();
        $data['booking_total'] = Booking::where('status','!=','canceled')->where('vendor_id','=',$input['vendor_id'])->sum('total');
        $data['offer_count'] = Offer::where('is_active','!=','0')->where('vendor_id','=',$input['vendor_id'])->count();
        $data['offer_total'] = Offer::where('is_active','!=','0')->where('vendor_id','=',$input['vendor_id'])->sum('offer_price');
        $data['customer_count'] = User::where('users.type','=','customer')->whereHas('bookings', function ($query) use ($input) {
            $query->where('vendor_id','=',$input['vendor_id']);
        })->count();
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
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            'year' => Booking::select(DB::raw('MONTH(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            'month' => Booking::select(DB::raw('DAY(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            'week' => Booking::select(DB::raw('DAYOFWEEK(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            default => Booking::select(DB::raw('HOUR(created_at) as x_key'), DB::raw('COUNT(id) as count'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->whereDate('created_at', $currentDate)
                ->where('vendor_id','=',$data['vendor_id'])
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
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            'year' => Booking::select(DB::raw('MONTH(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            'month' => Booking::select(DB::raw('DAY(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            'week' => Booking::select(DB::raw('DAYOFWEEK(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
            default => Booking::select(DB::raw('HOUR(created_at) as x_key'), DB::raw('SUM(total) as total'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where(DB::raw('WEEK(created_at)'), [$currentWeek])
                ->whereDate('created_at', $currentDate)
                ->where('vendor_id','=',$data['vendor_id'])
                ->groupBy('x_key')
                ->get(),
        };
    }



    public function booking_count_with_month_chart(array $data)
    {
        $year = array_key_exists('year',$data) ? $data['year'] : '2024';

        return Booking::select(DB::raw('MONTH(created_at) as x_key'), DB::raw('COUNT(id) as count'))
            ->whereYear('created_at', $year)
            ->where('vendor_id','=',$data['vendor_id'])
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
            ->where('vendor_id','=',$data['vendor_id'])
            ->groupBy('x_key')
            ->get();
    }

    public function last_bookings($data)
    {
        return Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->where('vendor_id','=',$data['vendor_id'])
            ->orderBy('id','desc')
            ->limit(10)
            ->get();
    }
    public function last_customers($data)
    {
        return User::select('users.*')->with(['bookings'=> function ($query) use($data) {
            $query->where('vendor_id','=',$data['vendor_id']);
        },'bookings.reviews','reviews'])
            ->where('users.type','=','customer')
            ->whereHas('bookings', function ($query) use ($data) {
                $query->where('vendor_id','=',$data['vendor_id']);
            })->orderBy('id','desc')
            ->limit(10)
            ->get();
    }




}
