<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\RoleRequest;
use App\Http\Requests\PaginateRequest;
use Spatie\Permission\Models\Role;
use App\Services\General\RoleService;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

use function response;

class RoleController extends Controller
{
    protected RoleService $service;
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }
    public function index()
    {

        $data = Role::where('model_type', 'vendor')->get();
        return response()->apiSuccess($data);
    }

    public function permissions()
    {
        $permissions = Permission::where('guard_name', 'api')->whereIn('model_type', ['vendor','general'])->get();
        return response()->apiSuccess($permissions);
    }
    public function show($id)
    {
        return response()->apiSuccess($this->service->get($id));
    }

    public function store(RoleRequest $request)
    {
        $data = $request->all();
        $data['model_type'] = 'admin';
        $data['guard_name'] = 'api';
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $data = $request->all();

            $data['model_type'] = 'admin';
            $data['guard_name'] = 'api';

        return response()->apiSuccess($this->service->update($data, $role));
    }
    public function delete(Role $role)
    {
        return response()->apiSuccess($this->service->delete($role));
    }

}
