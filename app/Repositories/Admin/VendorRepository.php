<?php

namespace App\Repositories\Admin;

use App\Models\Banner;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Offer;
use App\Models\Package;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vendor;
use App\Repositories\AbstractRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class VendorRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Vendor::class);
    }
    public function createVendor($data)
    {
        try {
            DB::beginTransaction();
            $vendorInput = [
                'name' => $data['provider_name'],
                'commercial_no' => $data['commercial_no'],
                'tax_number' => $data['tax_number'],
                'description' => $data['description'],
                'website_url' => $data['website_url'],
                'twitter' => $data['twitter'],
                'instagram' => $data['instagram'],
                'snapchat' => $data['snapchat'],
                'created_by' => $data['created_by'],
                'is_active' => $data['is_active'],
            ];
            $vendor = Vendor::create($vendorInput);
            if($vendor) {
                $userInput = [
                    'email' => $data['email'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'created_by' => $data['created_by'],
                    'model_id' => $vendor->id,
                    'type' => 'vendor',
                    'password' => Hash::make($data['password']),
                ];
                $user=User::create($userInput);
                $role = Role::firstOrCreate(['name' => 'admin','model_type' => 'vendor','can_edit' => 0], ['name' => 'admin','model_type' => 'vendor','can_edit' => 0]);

                if ($user && $role) {
                    $user->syncRoles($role->id);
                    $role->syncPermissions(Permission::whereIn('model_type', ['vendor','general'])->get());
                    Artisan::call('cache:clear');
                }
                $vendor->vendorCategories()->attach($data['category_id']);
                DB::commit();
                return $vendor;
            }
            DB::commit();
            return $vendor;
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, null, $e->getMessage(), null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function activate_vendor($data)
    {

            $vendorInput = [
                'updated_by' => $data['updated_by'],
                'is_active' => $data['is_active'],
            ];
            $vendor = Vendor::where('id',$data['vendor_id'])->update($vendorInput);

            return $vendor;
    }

    public function updateVendor($data,$vendor)
    {
        try {
            $vendor_id=$vendor->id;
            DB::beginTransaction();
            $vendorInput = [
                'name' => $data['provider_name'],
                'commercial_no' => $data['commercial_no'],
                'tax_number' => $data['tax_number'],
                'description' => $data['description'],
                'website_url' => $data['website_url'],
                'twitter' => $data['twitter'],
                'instagram' => $data['instagram'],
                'snapchat' => $data['snapchat'],
                'updated_by' => $data['updated_by'],
                'is_active' => $data['is_active'],
            ];
            $vendor = $vendor->update($vendorInput);
            if($vendor) {
                $userInput = [
                    'email' => $data['email'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'updated_by' => $data['updated_by'],
                ];
                $vendor=Vendor::where('id', $vendor_id)->first();
                $user=User::where('model_id', $vendor_id)->where('type', 'vendor')->first();
                if($user){
                    $user->update($userInput);
                }
                $vendor->vendorCategories()->attach($data['category_id']);
                DB::commit();
                return $vendor;
            }
            DB::commit();
            return $vendor;
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, null, $e->getMessage(), null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function vendor_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Vendor::select('vendors.*')->withCount(['bookings','services','offers','branches','user'])
            ->leftJoin('users', 'users.model_id', '=', 'vendors.id')
            ->leftJoin('wallets', 'users.id', '=', 'wallets.user_id')
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('vendors.name', 'like', '%'.$input['search'].'%');
            })->where('users.type','=','vendor');
        return $list->paginate($itemPerPage);
    }
    public function vendor_report_show($id)
    {
        return Vendor::select('vendors.*')->with(['bookings','services','offers','branches','user','user.wallet','user.wallet.transactions'])
            ->leftJoin('users', 'users.model_id', '=', 'vendors.id')
            ->leftJoin('wallets', 'users.id', '=', 'wallets.user_id')->find($id);

    }


    public function customer_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = User::select('users.*')->withCount(['bookings','reviews'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('users.first_name', 'like', '%'.$input['search'].'%');
                $query->orWhere('users.last_name', 'like', '%'.$input['search'].'%');
            })->where('users.type','=','customer');
        return $list->paginate($itemPerPage);
    }
    public function customer_report_show($id)
    {
        return User::select('users.*')->with(['bookings','reviews'])
           ->find($id);

    }

    public function employee_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Employee::select('employees.*')->with('user')->withCount(['bookings','branches','services']);
        return $list->paginate($itemPerPage);
    }
    public function employee_report_show($id)
    {
        return Employee::select('employees.*')->with(['bookings','branches','services','user'])
            ->find($id);

    }

    public function subscription_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Subscription::select('subscriptions.*')->with(['package','vendor'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('subscriptions.name_ar', 'like', '%'.$input['search'].'%');
                $query->orWhere('subscriptions.name_ar', 'like', '%'.$input['search'].'%');
            });
        return $list->paginate($itemPerPage);
    }
    public function subscription_report_show($id)
    {
        return Subscription::select('subscriptions.*')->with(['package','vendor','vendor.user'])
            ->find($id);

    }

    public function package_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Package::select('packages.*')->withCount(['subscriptions'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('packages.name_ar', 'like', '%'.$input['search'].'%');
                $query->orWhere('packages.name_ar', 'like', '%'.$input['search'].'%');
            });
        return $list->paginate($itemPerPage);
    }
    public function package_report_show($id)
    {
        return Package::select('packages.*')->withCount(['subscriptions'])
            ->find($id);

    }

    public function service_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        //->with(['category','section','employees','branches','vendor'])
        $list = Service::select('services.*')->withCount(['bookings','branches'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('services.name_ar', 'like', '%'.$input['search'].'%');
                $query->orWhere('services.name_ar', 'like', '%'.$input['search'].'%');
            });
        return $list->paginate($itemPerPage);
    }
    public function service_report_show($id)
    {
        return Service::select('services.*')->with(['category','section','employees','branches','vendor','vendor.user'])
            ->find($id);
    }
    public function offer_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        //->withCount(['bookings','services','section','category','sub_category','vendor'])
        $list = Offer::select('offers.*')->withCount(['bookings','services'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('services.name_ar', 'like', '%'.$input['search'].'%');
                $query->orWhere('services.name_ar', 'like', '%'.$input['search'].'%');
            });
        return $list->paginate($itemPerPage);
    }
    public function offer_report_show($id)
    {
        return Offer::select('offers.*')->with(['services','section','category','sub_category','vendor','vendor.user'])
            ->find($id);
    }
    public function booking_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','bookingService','bookingService.service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('services.payment_status', 'like', '%'.$input['search'].'%');
                $query->orWhere('services.payment_status', 'like', '%'.$input['search'].'%');
            });
        return $list->paginate($itemPerPage);
    }
    public function booking_report_show($id)
    {
        return Booking::select('bookings.*')->with(['createdBy','branch','vendor','vendor.user','reviews','bookingService','bookingService.service','user','offer','offer.services','promoCode','employee','employee.user'])
            ->find($id);
    }

}
