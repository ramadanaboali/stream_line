<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingCustomerInvoiceRequest;
use App\Models\Booking;
use App\Models\Subscription;
use App\Services\Vendor\HomeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function response;

class HomeController extends Controller
{
    protected HomeService $service;

    public function __construct(HomeService $service)
    {
        $this->service = $service;
    }
    public function successSubscribe (Request $request){
        $encData=$this->decrypt($request->trandata);
        $data=json_decode($encData);
        Log::debug("Success payment callback",$data);
        $subscription=Subscription::withTrashed()->findOrFail($data[0]->udf1);
        $today =Carbon::now();
        $activeSubscription=Subscription::where('vendor_id',$subscription->user_id)->where('status','active')->first();
        DB::beginTransaction();
        try {
            if(!$activeSubscription){
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days)->toDateString();
                $subscription->status='active';
                $subscription->save();
            } else if( $activeSubscription->end_date <= $today->toDateString()){
                $activeSubscription->status='finished';
                $activeSubscription->save();
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days)->toDateString();
                $subscription->status='active';
                $subscription->save();
            }else if($activeSubscription->package_id != $subscription->package_id){
                $activeSubscription->status='cancelled';
                $activeSubscription->save();
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days)->toDateString();
                $subscription->status='active';
                $subscription->save();
            }else{
                $activeSubscription->status='expanded';
                $activeSubscription->save();
                $diffInDays = Carbon::today()->diffInDays(Carbon::parse($activeSubscription->end_date));
                $subscription->payment_date=$today->toDateString();
                $subscription->start_date=$today->toDateString();
                $subscription->end_date=Carbon::now()->addDays($subscription->days+$diffInDays)->toDateString();
                $subscription->status='active';
                $subscription->save();
            }

            DB::commit();
//            return $subscription;
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
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }

    }
    public function errorSubscribe(Request $request){
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
    public function customer_report_list(Request $request)
    {
        $input = $request->all();
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        $data = $this->service->customer_report_list($input);
        return response()->apiSuccess($data);
    }

    public function customer_report_show($id)
    {
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->customer_report_show($id,$input));
    }

    public function subscription_report_list(Request $request)
    {
        $input = $request->all();
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        $data = $this->service->subscription_report_list($input);
        return response()->apiSuccess($data);
    }

    public function subscription_report_show($id)
    {
        return response()->apiSuccess($this->service->subscription_report_show($id));
    }

    public function service_report_list(Request $request)
    {
        $input = $request->all();
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        $data = $this->service->service_report_list($input);
        return response()->apiSuccess($data);
    }

    public function service_report_show($id)
    {
        return response()->apiSuccess($this->service->service_report_show($id));
    }

    public function offer_report_list(Request $request)
    {
        $input = $request->all();
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        $data = $this->service->offer_report_list($input);
        return response()->apiSuccess($data);
    }

    public function offer_report_show($id)
    {
        return response()->apiSuccess($this->service->offer_report_show($id));
    }

    public function booking_report_list(Request $request)
    {
        $input = $request->all();
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        $data = $this->service->booking_report_list($input);
        return response()->apiSuccess($data);
    }

    public function booking_report_show($id)
    {
        return response()->apiSuccess($this->service->booking_report_show($id));
    }
    public function booking_customer_invoice(BookingCustomerInvoiceRequest $request)
    {
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        $booking_id=$request->booking_id;
        $booking = Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','bookingService','bookingService.service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->find($booking_id);

        $html = view('booking_customer_invoice_pdf')->with(['data' =>$booking])->render();
        $mpdf = $this->getMpdf();
        $mpdf->WriteHTML($html);
        $file = 'booking_customer_invoice_'.Carbon::now().'.pdf';
        $mpdf->Output($file, 'D');

    }



    public function booking_vendor_invoice(BookingCustomerInvoiceRequest $request)
    {
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        $booking_id=$request->booking_id;
        $booking = Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','bookingService','bookingService.service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->find($booking_id);
        // $pdf = Pdf::loadView('booking_vendor_invoice_pdf', ['data' =>$booking]);

        // return $pdf->download('booking_vendor_invoice_'.Carbon::now().'.pdf');

        $html = view('booking_vendor_invoice_pdf')->with(['data' => $booking])->render();
        $mpdf = $this->getMpdf();
        $mpdf->WriteHTML($html);
        $file = 'booking_vendor_invoice_'.Carbon::now().'.pdf';
        $mpdf->Output($file, 'D');

    }
    public function home_totals(Request $request)
    {
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->home_totals($input));
    }
    public function pos_totals(Request $request)
    {
        $user=Auth::user();
        $input['user_id']=$user['id'];
        $input['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->pos_totals($input));
    }
    public function booking_count_chart(Request $request)
    {
        $data=$request->all();
        $user=Auth::user();
        $data['user_id']=$user['id'];
        $data['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->booking_count_chart($data));
    }
    public function booking_total_chart(Request $request)
    {
        $data=$request->all();
        $user=Auth::user();
        $data['user_id']=$user['id'];
        $data['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->booking_total_chart($data));
    }


    public function booking_count_with_month_chart(Request $request)
    {
        $data=$request->all();
        $user=Auth::user();
        $data['user_id']=$user['id'];
        $data['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->booking_count_with_month_chart($data));
    }
    public function register_count_with_month_chart(Request $request)
    {
        $data=$request->all();
        $user=Auth::user();
        $data['user_id']=$user['id'];
        $data['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->register_count_with_month_chart($data));
    }
    public function booking_count_last_week_chart(Request $request)
    {
        $data=$request->all();
        $user=Auth::user();
        $data['user_id']=$user['id'];
        $data['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->booking_count_last_week_chart($data));
    }
    public function last_bookings(Request $request)
    {
        $user=Auth::user();
        $data['user_id']=$user['id'];
        $data['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->last_bookings($data));
    }
    public function last_customers(Request $request)
    {
        $user=Auth::user();
        $data['user_id']=$user['id'];
        $data['vendor_id']=$user['model_id'];
        return response()->apiSuccess($this->service->last_customers($data));
    }







    public function getMpdf()
    {
        return new \Mpdf\Mpdf([
            'tempDir' => public_path('uploads/temp'),
            'mode' => 'utf-8',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'autoVietnamese' => true,
            'autoArabic' => true
        ]);

    }
}
