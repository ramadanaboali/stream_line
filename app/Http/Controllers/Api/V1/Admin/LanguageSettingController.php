<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageSettingRequest;
use App\Models\LanguageSetting;
use App\Services\Admin\LanguageSettingService;
use function response;

class LanguageSettingController extends Controller
{
    protected LanguageSettingService $service;
    public function __construct(LanguageSettingService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(LanguageSettingRequest $request)
    {
        $data = $request->only(['default']);
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
