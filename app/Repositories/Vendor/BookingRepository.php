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
    public function createItem($data){
        if (key_exists("employee_id", $data)) {
        $employee_id= $data["employee_id"];
        }else{
            $employee_id= $this->getAvailableEmployee($data['service_id'],$data['booking_day'],$data['booking_time']);
        }
        $service=Service::findOrFail($data['service_id']);
        $inputs = [
            'user_id'=>auth()->id(),
            'employee_id'=>$employee_id,
            'booking_day'=>$data['booking_day'],
            'vendor_id'=>$service->vendor_id,
            'booking_time'=>$data['booking_time'],
            'attendance'=>$data['attendance'],
            'sub_total'=>$data['sub_total'],
            'discount'=>$data['discount'],
            'total'=>$data['total'],
            'payment_way'=>$data['payment_way'],
            'discount_code'=>$data['discount_code']??null,
            'notes'=>$data['notes']??null,
            'service_id'=>$data['service_id'],
            'offer_id'=>$data['offer_id']??null,
            'is_active'=>$data['payment_way'] == 'online' ? 0 : 1,
        ];
        $booking= Booking::create($inputs);
        return $booking;
    }

     public function pay($id){
        try{
            $booking=Booking::findOrFail($id);
            $booking->payment_status=1;
            $booking->status='confirmed';
            $booking->is_active=1;
            return $booking->save();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }
    }
     public function cancel($id){
        try{
            $booking=Booking::findOrFail($id);
            $booking->status='canceled';
            return $booking->save();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }
    }

    protected function getAvailableEmployee($service_id,$day,$time)
    {
        $emplyee=Employee::whereHas('services', function ($q) use ($service_id,$day,$time) {
            $q->where('service_id', $service_id)
            ->leftJoin('bookings','bookings.service_id','=','services.id')
            ->leftJoin('official_hours','official_hours.model_id','=','employees.id')
            ->where('official_hours.type','work')
            ->where('official_hours.model_type',OfficialHour::TYPE_EMPLOYEE)
            ->where('official_hours.day',$day)
            ->where('official_hours.start_time','>=',$time)
            ->where('official_hours.end_time','<=',$day);
        })->where('is_active',1)->first();
        if ($emplyee) {
            return $emplyee->id;
        }
        return null;
    }
}
