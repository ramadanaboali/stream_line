<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaxSettingRequest;
use App\Models\TaxSetting;
use App\Services\Admin\TaxSettingService;
use function response;

class TaxSettingController extends Controller
{
    protected TaxSettingService $service;
    public function __construct(TaxSettingService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(TaxSettingRequest $request)
    {
        $data = $request->only(['tax_percentage']);
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
