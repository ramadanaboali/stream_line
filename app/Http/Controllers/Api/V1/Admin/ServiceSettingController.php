<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceSettingRequest;
use App\Models\ServiceSetting;
use App\Services\Admin\ServiceSettingService;
use function response;

class ServiceSettingController extends Controller
{
    protected ServiceSettingService $service;
    public function __construct(ServiceSettingService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(ServiceSettingRequest $request)
    {
        $data = $request->only(['difference_in_min']);
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
