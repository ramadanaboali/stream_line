<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActivateVendorRequest;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\BookingCustomerInvoiceRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\Booking;
use App\Models\User;
use App\Models\Vendor;
use App\Services\Admin\VendorService;
use App\Services\General\StorageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;
use function response;

class VendorController extends Controller
{
    protected VendorService $service;
    protected StorageService $storageService;

    public function __construct(VendorService $service, StorageService $storageService)
    {
        $this->service = $service;

        $this->storageService = $storageService;

    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Vendor();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->service->whereOptions($input, $columns);

        }
        $data = $this->service->Paginate($input, $wheres);
        return response()->apiSuccess($data);
    }

    public function show($id)
    {
        return response()->apiSuccess($this->service->get($id));
    }

    public function store(VendorRequest $request)
    {
        $data = $request->all();
        $data['created_by']=Auth::id();
        return response()->apiSuccess($this->service->createVendor($data));
    }
    public function activate_vendor(ActivateVendorRequest $request)
    {
        $data = $request->all();
        $data['updated_by']=Auth::id();
        return response()->apiSuccess($this->service->activate_vendor($data));
    }

    public function update(VendorRequest $request, Vendor $vendor)
    {
        $data = $request->all();
        $data['updated_by']=Auth::id();
        return response()->apiSuccess($this->service->updateVendor($data, $vendor));
    }
    public function delete(Vendor $vendor)
    {
        return response()->apiSuccess($this->service->delete($vendor));
    }

    public function vendor_report_list(Request $request)
    {
        $input = $request->all();
        $data = $this->service->vendor_report_list($input);
        return response()->apiSuccess($data);
    }

    public function vendor_report_show($id)
    {
        return response()->apiSuccess($this->service->vendor_report_show($id));
    }


    public function customer_counts(Request $request)
    {
        $data['all_customers'] = User::where('users.type','=','customer')->count();
        $data['new_customers'] = User::where('users.type','=','customer')->where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $data['old_customers'] = User::where('users.type','=','customer')->where('created_at', '<', Carbon::now()->subDays(7))->count();

        return response()->apiSuccess($data);
    }
    public function customer_report_list(Request $request)
    {
        $input = $request->all();
        $data = $this->service->customer_report_list($input);
        return response()->apiSuccess($data);
    }

    public function customer_report_show($id)
    {
        return response()->apiSuccess($this->service->customer_report_show($id));
    }
    public function employee_report_list(Request $request)
    {
        $input = $request->all();
        $data = $this->service->employee_report_list($input);
        return response()->apiSuccess($data);
    }

    public function employee_report_show($id)
    {
        return response()->apiSuccess($this->service->employee_report_show($id));
    }

    public function subscription_report_list(Request $request)
    {
        $input = $request->all();
        $data = $this->service->subscription_report_list($input);
        return response()->apiSuccess($data);
    }

    public function subscription_report_show($id)
    {
        return response()->apiSuccess($this->service->subscription_report_show($id));
    }
    public function package_report_list(Request $request)
    {
        $input = $request->all();
        $data = $this->service->package_report_list($input);
        return response()->apiSuccess($data);
    }

    public function package_report_show($id)
    {
        return response()->apiSuccess($this->service->package_report_show($id));
    }

    public function service_report_list(Request $request)
    {
        $input = $request->all();
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
        $data = $this->service->booking_report_list($input);
        return response()->apiSuccess($data);
    }

    public function booking_report_show($id)
    {
        return response()->apiSuccess($this->service->booking_report_show($id));
    }
    public function booking_customer_invoice(BookingCustomerInvoiceRequest $request)
    {
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
