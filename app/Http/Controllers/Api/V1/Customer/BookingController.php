<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingCustomerInvoiceRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Customer\PayRequest;
use App\Http\Requests\Customer\BookingRequest;
use App\Models\Booking;
use App\Models\PromoCode;
use App\Services\General\StorageService;
use App\Services\Customer\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

use function response;

class BookingController extends Controller
{
    protected BookingService $service;
    protected StorageService $storageService;

    public function __construct(BookingService $service, StorageService $storageService)
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
        $data = $this->service->Paginate($input, $wheres);
        return response()->apiSuccess($data);
    }

    public function show($id)
    {
        return response()->apiSuccess($this->service->getWithRelations($id,['bookingService','bookingService.service','offer']));
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
    public function checkPromocode($code)
    {
        return response()->apiSuccess($this->service->promocode($code));
    }
    public function pay(PayRequest $request)
    {
        $data= $request->all();
        return response()->apiSuccess($this->service->pay($data));
    }
    public function check_is_paid(PayRequest $request)
    {
        $data= $request->all();
        return response()->apiSuccess($this->service->check_is_paid($data));
    }
    public function cancel($id)
    {
        return response()->apiSuccess($this->service->cancel($id));
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
        return response()->apiSuccess($this->service->update($data, $bokking));
    }
    public function delete(Booking $bokking)
    {
        return response()->apiSuccess($this->service->delete($bokking));
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
    public function booking_customer_invoice(BookingCustomerInvoiceRequest $request)
    {
        $booking_id = $request->booking_id;
        $booking = Booking::select('bookings.*')->with(['createdBy', 'branch', 'vendor', 'vendor.user', 'reviews', 'bookingService', 'bookingService.service', 'user', 'offer', 'offer.services', 'promoCode', 'employee', 'employee.user'])
            ->find($booking_id);

        $html = view('booking_customer_invoice_pdf')->with(['data' => $booking])->render();
        $mpdf = $this->getMpdf();
        $mpdf->WriteHTML($html);
        $file = 'booking_customer_invoice_' . Carbon::now() . '.pdf';
        $mpdf->Output($file, 'D');
    }

}
