<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ClientCancellationReasonRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\ClientCancellationReason;
use App\Services\General\ClientCancellationReasonService;
use Illuminate\Support\Facades\Schema;
use function response;

class ClientCancellationReasonController extends Controller
{
    protected ClientCancellationReasonService $service;
    public function __construct(ClientCancellationReasonService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new ClientCancellationReason();
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

    public function store(ClientCancellationReasonRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(ClientCancellationReasonRequest $request, ClientCancellationReason $client_cancellation_reason)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$client_cancellation_reason));
    }
    public function delete(ClientCancellationReason $client_cancellation_reason)
    {
        return response()->apiSuccess($this->service->delete($client_cancellation_reason));
    }

}
