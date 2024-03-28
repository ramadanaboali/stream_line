<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Banner;
use App\Services\Admin\BannerService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class BannerController extends Controller
{
    protected BannerService $service;
    protected StorageService $storageService;
    public function __construct(BannerService $service,StorageService $storageService)
    {
        $this->service = $service;
        $this->storageService = $storageService;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Banner();
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

    public function store(BannerRequest $request)
    {
        // Handle image upload
        $data = $request->except('image');
        $folder_path="images/banner";
        $storedPath=null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $storedPath = $this->storageService->storeFile($file,$folder_path);
        }
        $data['image'] =$storedPath;
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $data = $request->except('image');
        $folder_path="images/banner";
        $storedPath=$banner->icon;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $storedPath = $this->storageService->storeFile($file,$folder_path);

        }
        $data['image'] =$storedPath;
        return response()->apiSuccess($this->service->update($data,$banner));
    }
    public function delete(Banner $banner)
    {
        return response()->apiSuccess($this->service->delete($banner));
    }

}
