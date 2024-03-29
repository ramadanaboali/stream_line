<?php

namespace App\Repositories\Vendor;

use App\Models\Booking;
use App\Models\Employee;
use App\Models\OfficialHour;
use App\Models\Service;
use App\Repositories\AbstractRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Booking::class);
    }
    public function createItem($data)
    {
        $service = Service::findOrFail($data['service_id']);
        if (key_exists("employee_id", $data)) {
            $employee_id = $data["employee_id"];
        } else {
            $employee_id = $this->getAvailableEmployee($data['service_id'], $data['booking_day'], $data['booking_time'],$service->vendor_id);
            if(empty($employee_id)){
                return ['data'=>[],'message'=>__('api.no_employee_available_in_this_time'),'success'=>false];
            }
        }
        $inputs = [
            'user_id' => auth()->id(),
            'employee_id' => $employee_id,
            'booking_day' => $data['booking_day'],
            'vendor_id' => $service->vendor_id,
            'booking_time' => $data['booking_time'],
            'attendance' => $data['attendance'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['discount'],
            'total' => $data['total'],
            'payment_way' => $data['payment_way'],
            'discount_code' => $data['discount_code'] ?? null,
            'notes' => $data['notes'] ?? null,
            'service_id' => $data['service_id'],
            'offer_id' => $data['offer_id'] ?? null,
            'is_active' => $data['payment_way'] == 'online' ? 0 : 1,
        ];
        $booking = Booking::create($inputs);
        return ['data' => $booking,'message' => __('api.create_success'),'success'=>true];

    }

    public function pay($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->payment_status = 1;
            $booking->status = 'confirmed';
            $booking->is_active = 1;
            return $booking->save();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    }
    public function cancel($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->status = 'canceled';
            return $booking->save();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    }

    protected function getAvailableEmployee($service_id, $booking_day, $time,$vendor_id)
    {
        $day=strtolower(date('D',strtotime($booking_day)));
        $not_available_employees=Booking::where('service_id',$service_id)
        ->where('booking_day',$booking_day)
        ->where('booking_time',$time)->pluck('employee_id')->toArray();
        $employee_donsnt_have_book = Employee::leftJoin('employee_services', 'employee_services.employee_id','employees.id')
        ->where('employee_services.service_id',$service_id)
        ->where('employees.vendor_id',$vendor_id)
        ->leftJoin('official_hours','official_hours.model_id','employees.id')
        ->where('official_hours.type','work')
        ->where('official_hours.model_type',OfficialHour::TYPE_EMPLOYEE)
        ->where('official_hours.day',$day)
        ->where('official_hours.start_time','<=',$time)
        ->where('official_hours.end_time','>',$time)
        ->whereNotIn('employees.id',$not_available_employees)->whereDoesntHave('bookings')->pluck('employees.id')->toArray();

        if(count($employee_donsnt_have_book)>0){
            return $employee_donsnt_have_book[0];
        }
        $available_employees = Employee::leftJoin('employee_services', 'employee_services.employee_id','employees.id')
        ->where('employee_services.service_id',$service_id)
        ->where('employees.vendor_id',$vendor_id)
        ->leftJoin('official_hours','official_hours.model_id','employees.id')
        ->where('official_hours.type','work')
        ->where('official_hours.model_type',OfficialHour::TYPE_EMPLOYEE)
        ->where('official_hours.day',$day)
        ->where('official_hours.start_time','<=',$time)
        ->where('official_hours.end_time','>',$time)
        ->whereNotIn('employees.id',$not_available_employees)->pluck('employees.id')->toArray();

        $min_employees = Booking::whereIn('employee_id',$available_employees)
        ->groupBy('employee_id')->select([
            'employee_id',
            DB::raw('count(employee_id) as total'),
        ])->orderBy('total','asc')->first();
        if ($min_employees) {
            return $min_employees->employee_id;
        }
        return null;
    }
}
