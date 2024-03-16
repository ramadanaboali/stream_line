<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Category;
use App\Services\General\CategoryService;
use Illuminate\Support\Facades\Schema;
use function response;

class CategoryController extends Controller
{
    protected CategoryService $service;
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Category();
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

    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$category));
    }
    public function delete(Category $category)
    {
        return response()->apiSuccess($this->service->delete($category));
    }

}
