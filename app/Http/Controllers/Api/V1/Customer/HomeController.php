<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SearchRequest;
use App\Http\Requests\Customer\VendorDetailsRequest;
use App\Models\Booking;
use App\Models\Offer;
use App\Models\Service;
use App\Models\Vendor;
use App\Models\VendorSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Psy\debug;
use function response;

class HomeController extends Controller
{
    public function vendor_details(VendorDetailsRequest $request)
    {
        $vendor_id=$request->vendor_id;
        $data = Vendor::with(["services","services.section","services.category","offers","offers.section","offers.category","branches","createdBy","user"])->find($vendor_id);
        return response()->apiSuccess($data);
    }
    public function getSetting(VendorDetailsRequest $request)
    {
        $vendor_id=$request->vendor_id;
            $query = [
                'is_active' => '1',
                "vendor_id"=> $vendor_id,
            ];

        $item=  VendorSetting::firstOrCreate($query, [
            "stock_alert"=> 1,
            "calender_differance"=> 10,
            "booking_differance"=> 1,
            "cancel_booking"=> 1,
            "reschedule_booking"=> 1,
        ]);
        return response()->apiSuccess($item);
    }
    public function search(SearchRequest $request)
    {
        $branchIds=null;
        if($request->filled('lat')){
            $latitude=$request->lat;
            $longitude=$request->long;
            $city_id=$request->city_id;
            $branchIds = DB::table('branches')
                ->select('id') // Select only the 'id' column
                ->selectRaw("(6371 * acos(cos(radians(?))
                 * cos(radians(lat))
                 * cos(radians(long) - radians(?))
                 + sin(radians(?))
                 * sin(radians(lat)))) AS distance", [$latitude, $longitude, $latitude])
                ->having('distance', '<=', 10);
                if($request->filled('city_id')) {
                    $branchIds->where('cit_id', $city_id);
                }
                $branchIds->orderBy('distance')
                ->pluck('id') // Get only the 'id' column as a collection
                ->toArray(); // Convert the collection to an array
        }
        $branchIds = $branchIds ?? [];
        $data['vendors'] = Vendor::with(["services","services.section","services.category","offers","branches","createdBy","user"])->where(function($query)use ($request,$branchIds){
                                    if($request->filled('search_text')) {
                                        $query->where("name", 'like', '%' . $request->search_text . '%');
                                    }
                                    if($request->filled('lat')) {
                                        $query->whereHas('branches', function ($queryIn) use ($branchIds) {
                                            $queryIn->whereIn('id', $branchIds);
                                        });
                                    }
                                })->limit(20)->get();

        $data['services']=Service::with(["category","vendor","createdBy","branches","section","employees","employees.officialHours","employees.user"])->where(function($query) use ($request,$branchIds){
                                if($request->filled('category_id')){
                                    $query->where('category_id',$request->category_id);
                                }
                                if($request->filled('search_text')){
                                    $query->where("name_ar", 'like', '%' . $request->search_text . '%')->orWhere("name_en", 'like', '%' . $request->search_text . '%');
                                }
                                if($request->filled('lat')) {
                                    $query->whereHas('branches', function ($queryIn) use ($branchIds) {
                                        $queryIn->whereIn('branch_id', $branchIds);
                                    });
                                }
                            })->limit(20)->get();

            $data['offers']=Offer::with(["category","services","services.section","services.category","createdBy","section"])->where(function($query) use ($request,$branchIds){
                if($request->filled('category_id')){
                    $query->where('category_id',$request->category_id);
                }
                if($request->filled('search_text')){
                    $query->where("name_ar", 'like', '%' . $request->search_text . '%')->orWhere("name_en", 'like', '%' . $request->search_text . '%');
                }
            })->limit(20)->get();

        return response()->apiSuccess($data);
    }

    public function responseURL (Request $request){
        $encData=$this->decrypt($request->trandata);
        $data=json_decode($encData);
        Log::debug("Success payment callback",$data);
        $booking=Booking::withTrashed()->findOrFail($data[0]->udf1);
        $booking->update(['status'=>'confirmed','payment_status'=>'1','is_active'=>'1']);
        $htmlContent = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Callback Response</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h1 { color: #333; }
                    p { color: #666; }
                </style>
            </head>
            <body>
                <h1>Payment Received Successfully</h1>
                <p>Payment Done Please Close this and Return To main Page.</p>
            </body>
            </html>
        ';

        return response($htmlContent, 200)
            ->header('Content-Type', 'text/html');
//        return response()->apiSuccess($booking);
    }
    public function errorURL(Request $request){
        Log::debug("error payment callback",$request->all());
        $response=$request->all();
//        $encData=$this->decrypt($request->trandata);
//        $data=json_decode($encData);
        $htmlContent = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Callback Response</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h1 { color: #333; }
                    p { color: #666; }
                </style>
            </head>
            <body>
                <h1>Payment Received With Error</h1>
                <p>Payment Failed Please Close this and Return To main Page.</p>
                <p>'.$request->errorText.'</p>
            </body>
            </html>
        ';

        return response($htmlContent, 200)
            ->header('Content-Type', 'text/html');
//        return response()->apiSuccess($request->all());
    }

    public function decrypt($code)
    {
        $key=config('banck.resource_key');
        $string = hex2bin(trim($code));
        $code = unpack('C*', $string);
        $chars = array_map("chr", $code);
        $code = join($chars);
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, "AES-256-CBC", $key, OPENSSL_ZERO_PADDING, "PGKEYENCDECIVSPC");
        $pad = ord($decrypted[strlen($decrypted) - 1]);
        if ($pad > strlen($decrypted)) {
            return false;
        }
        if (strspn($decrypted, chr($pad), strlen($decrypted) - $pad) != $pad) {
            return false;
        }
        return urldecode(substr($decrypted, 0, -1 * $pad));
    }

}
