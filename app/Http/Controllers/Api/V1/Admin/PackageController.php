<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Package;
use App\Services\Admin\PackageService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class PackageController extends Controller
{
    protected PackageService $service;
    public function __construct(PackageService $service)
    {
        $this->service = $service;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Package();
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

    public function store(PackageRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(PackageRequest $request, Package $package)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$package));
    }
    public function delete(Package $package)
    {
        return response()->apiSuccess($this->service->delete($package));
    }

}
