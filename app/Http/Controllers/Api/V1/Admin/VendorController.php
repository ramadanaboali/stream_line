<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\Vendor;
use App\Services\Admin\VendorService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use function response;

class VendorController extends Controller
{
    protected VendorService $service;
    protected StorageService $storageService;

    public function __construct(VendorService $service, StorageService $storageService)
    {
        $this->service = $service;

        $this->storageService = $storageService;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Vendor();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->service->whereOptions($input, $columns);

        }
        return [];
        $data = $this->service->Paginate($input, $wheres);
        return response()->apiSuccess($data);
    }

    public function show($id)
    {
        return response()->apiSuccess($this->service->get($id));
    }

    public function store(VendorRequest $request)
    {
        $data = $request->all();
        $data['created_by']=Auth::id();
        return response()->apiSuccess($this->service->createVendor($data));
    }

    public function update(VendorRequest $request, Vendor $vendor)
    {
        $data = $request->all();
        $data['updated_by']=Auth::id();
        return response()->apiSuccess($this->service->updateVendor($data, $vendor));
    }
    public function delete(Vendor $vendor)
    {
        return response()->apiSuccess($this->service->delete($vendor));
    }

}
