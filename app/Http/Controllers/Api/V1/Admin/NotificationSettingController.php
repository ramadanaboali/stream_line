<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationSettingRequest;
use App\Models\NotificationSetting;
use App\Services\Admin\NotificationSettingService;
use function response;

class NotificationSettingController extends Controller
{
    protected NotificationSettingService $service;
    public function __construct(NotificationSettingService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(NotificationSettingRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
