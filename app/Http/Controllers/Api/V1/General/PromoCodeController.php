<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\PromoCodeRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\PromoCode;
use App\Services\General\PromoCodeService;
use Illuminate\Support\Facades\Schema;
use function response;

class PromoCodeController extends Controller
{
    protected PromoCodeService $service;
    public function __construct(PromoCodeService $service)
    {
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new PromoCode();
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

    public function store(PromoCodeRequest $request)
    {
        $data = $request->all();
        $data["code"] =$this->createUniquePromoCode(10);
        return response()->apiSuccess($this->service->store($data));
    }

    // Function to generate a random alphanumeric code
    private function createUniquePromoCode($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $promoCode = '';

        do {
            for ($i = 0; $i < $length; $i++) {
                $promoCode .= $characters[rand(0, $charactersLength - 1)];
            }
        } while (PromoCode::where('code', $promoCode)->exists());

        return $promoCode;
    }

    public function update(PromoCodeRequest $request, PromoCode $promo_code)
    {
        $data = $request->all();
        return response()->apiSuccess($this->service->update($data,$promo_code));
    }
    public function delete(PromoCode $promo_code)
    {
        return response()->apiSuccess($this->service->delete($promo_code));
    }

}
