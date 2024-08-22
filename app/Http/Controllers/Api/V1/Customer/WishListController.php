<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Customer\WishListRequest;
use App\Models\WishList;
use App\Services\Customer\WishListService;
use Illuminate\Support\Facades\Schema;

use function response;

class WishListController extends Controller
{
    protected WishListService $service;
    public function __construct(WishListService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new WishList();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->service->whereOptions($input, $columns);
        }
        $data = $this->service->Paginate($input, $wheres);
        return response()->apiSuccess($data);
    }

    public function show($id)
    {
        return response()->apiSuccess($this->service->get($id));
    }

    public function store(WishListRequest $request)
    {

        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(WishListRequest $request, WishList $wish_list)
    {

        $data = $request->all();
        return response()->apiSuccess($this->service->update($data, $wish_list));
    }
    public function delete(WishList $wish_list)
    {
        return response()->apiSuccess($this->service->delete($wish_list));
    }

}
