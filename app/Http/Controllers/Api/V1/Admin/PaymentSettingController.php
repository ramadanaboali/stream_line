<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentSettingRequest;
use App\Models\PaymentSetting;
use App\Services\Admin\PaymentSettingService;
use function response;

class PaymentSettingController extends Controller
{
    protected PaymentSettingService $service;
    public function __construct(PaymentSettingService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(PaymentSettingRequest $request)
    {
        $data = $request->only(['online_payment', 'online_on_delivery_payment']);
        if($data['online_payment'] == '0' && $data['online_on_delivery_payment'] == '0'){
            return response()->apiFail('you can not disable all payment methods');
        }
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
