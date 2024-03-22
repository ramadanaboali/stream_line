<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TermConditionRequest;
use App\Models\TermCondition;
use App\Services\Admin\TermConditionService;
use function response;

class TermConditionController extends Controller
{
    protected TermConditionService $service;
    public function __construct(TermConditionService $service)
    {
        $this->service = $service;

    }
    public function getSetting(){
        return response()->apiSuccess($this->service->getSetting());
    }

    public function updateSetting(TermConditionRequest $request)
    {
        $data = $request->only(['content']);
        return response()->apiSuccess($this->service->updateSetting($data));
    }


}
