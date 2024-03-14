<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class UnitController extends Controller
{
    protected UnitService $service;
    public function __construct(UnitService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Unit();
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

    public function store(UnitRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$unit));
    }

}
