<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\VendorSettingRepository;
use App\Services\AbstractService;
class VendorSettingService extends AbstractService
{
    protected $repo;
    public function __construct(VendorSettingRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function getSetting(){
        $user_id= auth()->user()->id;
        $vendor= auth()->user()->vendor;
        return $this->repo->getSetting($user_id,$vendor);
    }
    public function updateSetting(array $data){
        $user_id= auth()->user()->id;
        $vendor= auth()->user()->vendor();
        return $this->repo->updateSetting($data,$user_id,$vendor);
    }
  }
