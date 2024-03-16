<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CountryRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Country;
use App\Services\General\CountryService;
use Illuminate\Support\Facades\Schema;
use function response;

class CountryController extends Controller
{
    protected CountryService $service;
    public function __construct(CountryService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Country();
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

    public function store(CountryRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(CountryRequest $request, Country $country)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$country));
    }
    public function delete(Country $country)
    {
        return response()->apiSuccess($this->service->delete($country));
    }

}
