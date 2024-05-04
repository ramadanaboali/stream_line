<?php

namespace App\Repositories\Vendor;

use App\Models\Employee;
use App\Models\EmployeeBranch;
use App\Models\OfficialHour;
use App\Models\User;
use App\Repositories\AbstractRepository;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository extends AbstractRepository
{
    protected StorageService $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
        parent::__construct(Employee::class);
    }

    public function officialHours($officialHours, $id){
        foreach ($officialHours as $officialHour) {
            $data['start_time']=$officialHour['start_time'];
            $data['end_time']=$officialHour['end_time'];
            $data['day']=$officialHour['day'];
            $data['type']='work';
            $data['model_type']=OfficialHour::TYPE_EMPLOYEE;
            $data['model_id']=$id;
            $data['created_by'] = auth()->user()->id;
            OfficialHour::create($data);
        }
    }
    public function breakHours($officialHours, $id){
        foreach ($officialHours as $officialHour) {
            $data['start_time']=$officialHour['start_time'];
            $data['end_time']=$officialHour['end_time'];
            $data['day']=$officialHour['day'];
            $data['type']='break';
            $data['model_type']=OfficialHour::TYPE_EMPLOYEE;
            $data['model_id']=$id;
            $data['created_by'] = auth()->user()->id;
            OfficialHour::create($data);
        }
    }

    public function createItem(array $data)
    {
        try {
            DB::beginTransaction();
            $inputUser = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'image' => $data['image'],
                'model_id' => $data['vendor_id'],
                'type' => 'vendor',
                'created_by'=> $data['created_by'],
                'password' => Hash::make($data['password']),
            ];
            $user = User::create($inputUser);
            $inputEmployee = [
                'user_id'=> $user->id,
                'vendor_id'=> $data['vendor_id'],
                'salary'=> $data['salary'] ?? null,
                'start_date'=> $data['start_date'],
                'end_date'=> $data['end_date'] ?? null,
                'created_by'=> $data['created_by'],
            ];
            $employee=Employee::create($inputEmployee);

            $employee->branches()->attach($data['branch_id']);
            if (key_exists('service_id', $data)) {
                $employee->services()->attach($data['service_id']);
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    public function employeeService(array $data)
    {
        try {
            $employee=Employee::findOrFail($data['employee_id']);
            $employee->services()->attach($data['service_id']);
            return $employee;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    public function updateItem($data,$item)
    {
        try {

            DB::beginTransaction();
            $user = User::findOrFail($item->user_id);
            $inputUser = [
                'first_name' => $data['first_name'] ?? $user->first_name,
                'last_name' => $data['last_name'] ?? $user->last_name,
                'email' => $data['email'] ?? $user->email,
                'phone' => $data['phone'] ?? $user->phone,
                'image' => $data['image'] ?? $user->image,
                'password' => Hash::make($data['password']),
            ];
            $user->update($inputUser);
            $inputEmployee = [
                'salary' => $data['salary'] ?? null,
                'start_date' => $data['start_date']??$item->start_date,
                'end_date' => $data['end_date'] ?? $item->end_date,
                'updated_by' => auth()->user()->id,
            ];
            $item->update($inputEmployee);
            if (key_exists('branch_id', $data)) {
                $item->branches()->detach();
                $item->branches()->attach($data['branch_id']);
            }
            if (key_exists('service_id', $data)) {
                $item->services()->detach();
                $item->services()->attach($data['service_id']);
            }

            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
