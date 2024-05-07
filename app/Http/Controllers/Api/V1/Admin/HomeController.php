<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\HomeService;
use Illuminate\Http\Request;
use function response;

class HomeController extends Controller
{
    protected HomeService $service;

    public function __construct(HomeService $service)
    {
        $this->service = $service;
    }

    public function home_totals(Request $request)
    {
        return response()->apiSuccess($this->service->home_totals());
    }
    public function booking_count_chart(Request $request)
    {
        $data=$request->all();
        return response()->apiSuccess($this->service->booking_count_chart($data));
    }
    public function booking_total_chart(Request $request)
    {
        $data=$request->all();
        return response()->apiSuccess($this->service->booking_total_chart($data));
    }

}
