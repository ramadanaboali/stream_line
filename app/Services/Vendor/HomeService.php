<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\HomeRepository;
use App\Services\AbstractService;
class HomeService extends AbstractService
{
    protected $repo;
    public function __construct(HomeRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function home_totals(array $input)
    {
        return $this->repo->home_totals($input);
    }
    public function pos_totals(array $input)
    {
        return $this->repo->pos_totals($input);
    }
    public function booking_count_chart(array $data)
    {
        return $this->repo->booking_count_chart($data);
    }
    public function booking_total_chart(array $data)
    {
        return $this->repo->booking_total_chart($data);
    }
    public function booking_count_with_month_chart(array $data)
    {
        return $this->repo->booking_count_with_month_chart($data);
    }
    public function register_count_with_month_chart(array $data)
    {
        return $this->repo->register_count_with_month_chart($data);
    }
    public function booking_count_last_week_chart(array $data)
    {
        return $this->repo->booking_count_last_week_chart($data);
    }
    public function last_bookings(array $data)
    {
        return $this->repo->last_bookings($data);
    }
    public function last_customers(array $data)
    {
        return $this->repo->last_customers($data);
    }


    public function customer_report_list(array $input)
    {
        return $this->repo->customer_report_list($input);
    }
    public function customer_report_show($id,array $input)
    {
        return $this->repo->customer_report_show($id,$input);
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
    public function offer_report_list(array $input)
    {
        return $this->repo->offer_report_list($input);
    }
    public function offer_report_show($id)
    {
        return $this->repo->offer_report_show($id);
    }
    public function booking_report_list(array $input)
    {
        return $this->repo->booking_report_list($input);
    }
    public function booking_report_show($id)
    {
        return $this->repo->booking_report_show($id);
    }
}
