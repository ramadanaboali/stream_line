<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\WalletRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Wallet;
use App\Services\General\WalletService;
use Illuminate\Support\Facades\Schema;
use function response;

class WalletController extends Controller
{
    protected WalletService $service;
    public function __construct(WalletService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Wallet();
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

    public function store(WalletRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(WalletRequest $request, Wallet $wallet)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$wallet));
    }
    public function delete(Wallet $wallet)
    {
        return response()->apiSuccess($this->service->delete($wallet));
    }

}
