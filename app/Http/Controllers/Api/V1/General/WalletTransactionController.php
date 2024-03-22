<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\WalletTransactionRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\WalletTransaction;
use App\Services\General\WalletTransactionService;
use Illuminate\Support\Facades\Schema;
use function response;

class WalletTransactionController extends Controller
{
    protected WalletTransactionService $service;
    public function __construct(WalletTransactionService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new WalletTransaction();
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

    public function store(WalletTransactionRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(WalletTransactionRequest $request, WalletTransaction $wallet_transaction)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$wallet_transaction));
    }
    public function delete(WalletTransaction $wallet_transaction)
    {
        return response()->apiSuccess($this->service->delete($wallet_transaction));
    }

}
