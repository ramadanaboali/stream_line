<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrivacyPolicyRequest;
use App\Models\PrivacyPolicy;
use App\Services\Admin\PrivacyPolicyService;
use function response;

class PrivacyPolicyController extends Controller
{
    protected PrivacyPolicyService $service;
    public function __construct(PrivacyPolicyService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(PrivacyPolicyRequest $request)
    {
        $data = $request->only(['content']);
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
