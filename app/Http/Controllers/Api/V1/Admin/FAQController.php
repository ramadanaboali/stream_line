<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FAQRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\FAQ;
use App\Services\Admin\FAQService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class FAQController extends Controller
{
    protected FAQService $service;
    public function __construct(FAQService $service)
    {
        $this->service = $service;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new FAQ();
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

    public function store(FAQRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(FAQRequest $request, FAQ $f_a_q)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$f_a_q));
    }
    public function delete(FAQ $f_a_q)
    {
        return response()->apiSuccess($this->service->delete($f_a_q));
    }

}
