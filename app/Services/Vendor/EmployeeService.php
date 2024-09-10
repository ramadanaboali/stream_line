<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\EmployeeRepository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Log;

class EmployeeService extends AbstractService
{
    protected $repo;
    public function __construct(EmployeeRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }

     public function createItem($data){
        try{
            return $this->repo->createItem($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
     public function employeeService($data){
        try{
            return $this->repo->employeeService($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateItem($data,$item){
        try{
            return $this->repo->updateItem($data, $item);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function officialHours($officialHours,$id){
        $this->repo->officialHours($officialHours,$id);
    }
    public function breakHours($officialHours,$id){
        $this->repo->breakHours($officialHours,$id);
    }
}
