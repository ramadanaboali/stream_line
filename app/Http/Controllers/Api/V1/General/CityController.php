<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CityRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\City;
use App\Services\General\CityService;
use Illuminate\Support\Facades\Schema;
use function response;

class CityController extends Controller
{
    protected CityService $service;
    public function __construct(CityService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new City();
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

    public function store(CityRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(CityRequest $request, City $city)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$city));
    }
    public function delete(City $city)
    {
        return response()->apiSuccess($this->service->delete($city));
    }

}
