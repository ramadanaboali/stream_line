<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ReviewReportRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\ReviewReport;
use App\Services\General\ReviewReportService;
use Illuminate\Support\Facades\Schema;
use function response;

class ReviewReportController extends Controller
{
    protected ReviewReportService $service;
    public function __construct(ReviewReportService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new ReviewReport();
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

    public function store(ReviewReportRequest $request)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->store($data));
    }

    public function update(ReviewReportRequest $request, ReviewReport $review_report)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$review_report));
    }
    public function delete(ReviewReport $review_report)
    {
        return response()->apiSuccess($this->service->delete($review_report));
    }

}
