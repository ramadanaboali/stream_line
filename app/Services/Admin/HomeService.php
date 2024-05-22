<?php

namespace App\Services\Admin;

use App\Repositories\Admin\HomeRepository;
use App\Services\AbstractService;

class HomeService extends AbstractService
{
    protected $repo;
    public function __construct(HomeRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
    public function home_totals()
    {
        return $this->repo->home_totals();
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
    public function last_bookings()
    {
        return $this->repo->last_bookings();
    }
    public function last_customers()
    {
        return $this->repo->last_customers();
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
