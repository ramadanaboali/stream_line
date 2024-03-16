<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\RegionRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Region;
use App\Services\General\RegionService;
use Illuminate\Support\Facades\Schema;
use function response;

class RegionController extends Controller
{
    protected RegionService $service;
    public function __construct(RegionService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Region();
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

    public function store(RegionRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(RegionRequest $request, Region $region)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$region));
    }
    public function delete(Region $region)
    {
        return response()->apiSuccess($this->service->delete($region));
    }

}
