<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Vendor\BranchRequest;
use App\Models\Branch;
use App\Services\Vendor\BranchService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class BranchController extends Controller
{
    protected BranchService $service;
    public function __construct(BranchService $service)
    {
        $this->service = $service;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Branch();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->service->whereOptions($input, $columns);

        }
        $data = $this->service->Paginate($input, $wheres);
        //$meta = $this->service->Meta($data,$input);
        return response()->apiSuccess($data);
    }

    public function show($id){
        return response()->apiSuccess($this->service->get($id));
    }

    public function store(BranchRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$branch));
    }
    public function delete(Branch $branch)
    {
        return response()->apiSuccess($this->service->delete($branch));
    }

}
