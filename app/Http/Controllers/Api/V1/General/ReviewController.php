<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ReviewRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Review;
use App\Services\General\ReviewService;
use Illuminate\Support\Facades\Schema;
use function response;

class ReviewController extends Controller
{
    protected ReviewService $service;
    public function __construct(ReviewService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Review();
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

    public function store(ReviewRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$review));
    }
    public function delete(Review $review)
    {
        return response()->apiSuccess($this->service->delete($review));
    }

}
