<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingCustomerInvoiceRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Vendor\BookingRequest;
use App\Models\Booking;
use App\Services\General\StorageService;
use App\Services\Vendor\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use function response;

class BookingController extends Controller
{
    protected BookingService $service;
    protected StorageService $storageService;

    public function __construct(BookingService $service,StorageService $storageService)
    {
        $this->storageService = $storageService;
        $this->service = $service;
    }
    public function index(PaginateRequest $request)
    {
        $input = $this->service->inputs($request->all());
        $model = new Booking();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {

            $wheres = $this->service->whereOptions($input, $columns);
        }
        $wheres[] = ['vendor_id','=', auth()->id()];
        $data = $this->service->Paginate($input, $wheres);
        return response()->apiSuccess($data);
    }

    public function show($id){
        return response()->apiSuccess($this->service->getWithRelations($id,["user","branch",'bookingService','bookingService.service',"offer","createdBy","employee","vendor","reviews"]));
    }

    public function store(BookingRequest $request)
    {

        $data = $request->all();
        $result = $this->service->createItem($data);
        if($result['success']){
            return response()->apiSuccess($result['data'],$result['message']);
        }
        return response()->apiFail($result['message']);

    }

    public function update(BookingRequest $request, Booking $bokking)
    {

        $data = $request->except(['image','_method']);
        if ($request->hasFile('image')) {
            $folder_path = "images/Booking";
            $storedPath = null;
            $file = $request->file('image');
            $storedPath = $this->storageService->storeFile($file, $folder_path);
            $data['image'] = $storedPath;
        }
        return response()->apiSuccess($this->service->update($data,$bokking));
    }
    public function delete(Booking $bokking)
    {
        return response()->apiSuccess($this->service->delete($bokking));
    }
    public function cancel($id)
    {
        return response()->apiSuccess($this->service->cancel($id));
    }
    public function booking_customer_invoice(BookingCustomerInvoiceRequest $request)
    {
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
