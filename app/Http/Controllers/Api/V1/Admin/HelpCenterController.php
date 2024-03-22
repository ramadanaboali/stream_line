<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HelpCenterRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\HelpCenter;
use App\Services\Admin\HelpCenterService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class HelpCenterController extends Controller
{
    protected HelpCenterService $service;
    protected StorageService $storageService;
    public function __construct(HelpCenterService $service,StorageService $storageService)
    {
        $this->service = $service;
        $this->storageService = $storageService;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new HelpCenter();
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

    public function store(HelpCenterRequest $request)
    {
        // Handle image upload
        $data = $request->except(['image','video']);
        $folder_path="images/help_center";
        $video_folder_path="video/help_center";
        $storedPath=null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $storedPath = $this->storageService->storeFile($file,$folder_path);
        }
        $storedVideoPath=null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $storedVideoPath = $this->storageService->storeFile($file,$video_folder_path);
        }
        $data['image'] =$storedPath;
        $data['video'] =$storedVideoPath;
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(HelpCenterRequest $request, HelpCenter $help_center)
    {
        $data = $request->except(['image','video']);
        $folder_path="images/help_center";
        $video_folder_path="video/help_center";
        $storedPath=$help_center->image;
        $storedVideoPath=$help_center->video;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $storedPath = $this->storageService->storeFile($file,$folder_path);

        }
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $storedVideoPath = $this->storageService->storeFile($file,$video_folder_path);
        }
        $data['image'] =$storedPath;
        $data['video'] =$storedVideoPath;
        return response()->apiSuccess($this->service->update($data,$help_center));
    }
    public function delete(HelpCenter $help_center)
    {
        return response()->apiSuccess($this->service->delete($help_center));
    }

}
