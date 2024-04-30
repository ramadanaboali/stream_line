<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ServiceCategoryRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\ServiceCategory;
use App\Services\General\ServiceCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use function response;

class ServiceCategoryController extends Controller
{
    protected ServiceCategoryService $service;
    public function __construct(ServiceCategoryService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new ServiceCategory();
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

    public function store(Request $request)
    {
        $data = $request->all();
        dd($data);
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(ServiceCategoryRequest $request, ServiceCategory $service_category)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$service_category));
    }
    public function delete(ServiceCategory $service_category)
    {
        return response()->apiSuccess($this->service->delete($service_category));
    }

}
