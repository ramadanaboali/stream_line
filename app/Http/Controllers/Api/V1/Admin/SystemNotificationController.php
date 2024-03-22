<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SystemNotificationRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\SystemNotification;
use App\Services\Admin\SystemNotificationService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class SystemNotificationController extends Controller
{
    protected SystemNotificationService $service;
    public function __construct(SystemNotificationService $service)
    {
        $this->service = $service;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new SystemNotification();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->service->whereOptions($input, $columns);

        }
        $data = $this->service->Paginate($input, $wheres);
//        $meta = $this->service->Meta($data,$input);
        return response()->apiSuccess($data);
    }

    public function show($id){
        return response()->apiSuccess($this->service->get($id));
    }

    public function store(SystemNotificationRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(SystemNotificationRequest $request, SystemNotification $system_notification)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$system_notification));
    }
    public function delete(SystemNotification $system_notification)
    {
        return response()->apiSuccess($this->service->delete($system_notification));
    }

}
