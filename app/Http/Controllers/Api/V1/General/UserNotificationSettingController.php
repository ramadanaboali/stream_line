<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\UserNotificationSettingRequest;
use App\Models\UserNotificationSetting;
use App\Services\General\UserNotificationSettingService;
use function response;

class UserNotificationSettingController extends Controller
{
    protected UserNotificationSettingService $service;
    public function __construct(UserNotificationSettingService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(UserNotificationSettingRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
