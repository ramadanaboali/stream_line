<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;

use function response;

class HomeController extends Controller
{
    public function search(Request $request)
    {
        $data['vendors'] = Vendor::where(function($query)use ($request){
                                    if($request->filled('search_text')) {
                                        $query->where("name", 'like', '%' . $request->search_text . '%');
                                    }
                                })->get();

        $data['services']=Service::where(function($query) use ($request){
                                if($request->filled('category_id')){
                                    $query->where('category_id',$request->category_id);
                                }
                                if($request->filled('search_text')){
                                    $query->where("name_ar", 'like', '%' . $request->search_text . '%')->orWhere("name_en", 'like', '%' . $request->search_text . '%');
                                }
                            })->get();

        return response()->apiSuccess($data);
    }


}
