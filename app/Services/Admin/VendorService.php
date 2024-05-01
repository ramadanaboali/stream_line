<?php

namespace App\Services\Admin;

use App\Repositories\Admin\VendorRepository;
use App\Services\AbstractService;

class VendorService extends AbstractService
{
    protected $repo;
    public function __construct(VendorRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function createVendor(array $data){
        return $this->repo->createVendor($data);
    }
    public function updateVendor(array $data,$vendor){
        return $this->repo->updateVendor($data,$vendor);
    }
    public function vendor_report_list(array $input)
    {
        return $this->repo->vendor_report_list($input);
    }
    public function vendor_report_show($id)
    {
        return $this->repo->vendor_report_show($id);
    }

    public function customer_report_list(array $input)
    {
        return $this->repo->customer_report_list($input);
    }
    public function customer_report_show($id)
    {
        return $this->repo->customer_report_show($id);
    }
    public function subscription_report_list(array $input)
    {
        return $this->repo->subscription_report_list($input);
    }
    public function subscription_report_show($id)
    {
        return $this->repo->subscription_report_show($id);
    }
    public function service_report_list(array $input)
    {
        return $this->repo->service_report_list($input);
    }
    public function service_report_show($id)
    {
        return $this->repo->service_report_show($id);
    }
}
