<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactMessageRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\ContactMessage;
use App\Services\Admin\ContactMessageService;
use App\Services\General\StorageService;
use Illuminate\Support\Facades\Schema;
use function response;

class ContactMessageController extends Controller
{
    protected ContactMessageService $service;
    public function __construct(ContactMessageService $service)
    {
        $this->service = $service;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new ContactMessage();
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

    public function store(ContactMessageRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(ContactMessageRequest $request, ContactMessage $contact_message)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$contact_message));
    }
    public function delete(ContactMessage $contact_message)
    {
        return response()->apiSuccess($this->service->delete($contact_message));
    }

}
