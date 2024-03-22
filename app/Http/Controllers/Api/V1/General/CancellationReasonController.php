<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CancellationReasonRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\CancellationReason;
use App\Services\General\CancellationReasonService;
use Illuminate\Support\Facades\Schema;
use function response;

class CancellationReasonController extends Controller
{
    protected CancellationReasonService $service;
    public function __construct(CancellationReasonService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new CancellationReason();
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

    public function store(CancellationReasonRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(CancellationReasonRequest $request, CancellationReason $cancellation_reason)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$cancellation_reason));
    }
    public function delete(CancellationReason $cancellation_reason)
    {
        return response()->apiSuccess($this->service->delete($cancellation_reason));
    }

}
