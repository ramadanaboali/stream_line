<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Category;
use App\Services\General\CategoryService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class CategoryController extends Controller
{
    protected CategoryService $service;
    protected StorageService $storageService;
    public function __construct(CategoryService $service,StorageService $storageService)
    {
        $this->service = $service;
        $this->storageService = $storageService;

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
        // Handle image upload
        $data = $request->except('icon');
        $folder_path="images/category";
        $storedPath=null;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $storedPath = $this->storageService->storeFile($file,$folder_path);
        }
        $data['icon'] =$storedPath;
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->except('icon');
        $folder_path="images/category";
        $storedPath=$category->icon;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $storedPath = $this->storageService->storeFile($file,$folder_path);

        }
        $data['icon'] =$storedPath;
        return response()->apiSuccess($this->service->update($data,$category));
    }
    public function delete(Category $category)
    {
        return response()->apiSuccess($this->service->delete($category));
    }

}
