<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingCustomerInvoiceRequest;
use App\Models\Booking;
use App\Services\Vendor\HomeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function response;

class HomeController extends Controller
{
    protected HomeService $service;

    public function __construct(HomeService $service)
    {
        $this->service = $service;
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
        $booking = Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','service','user','offer','offer.services','promoCode','employee','employee.user'])
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
        $booking = Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','service','user','offer','offer.services','promoCode','employee','employee.user'])
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
