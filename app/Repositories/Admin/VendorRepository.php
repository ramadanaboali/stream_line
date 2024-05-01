<?php

namespace App\Repositories\Admin;

use App\Models\Banner;
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
        $list = Vendor::with(['bookings','services','branches','user'])->select(['vendors.name','wallets.balance','users.email'])
            ->leftJoin('users', 'users.model_id', '=', 'vendors.id')
            ->leftJoin('wallets', 'users.id', '=', 'wallets.user_id')
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('vendors.name', 'like', '%'.$input['search'].'%');
            })->where('users.type','=','vendor');
        return$list->paginate($itemPerPage);
    }
    public function vendor_report_show($id)
    {
        return Vendor::select('vendors.*')->with(['bookings','services','branches','user','user.wallet','user.wallet.transactions'])
            ->leftJoin('users', 'users.model_id', '=', 'vendors.id')
            ->leftJoin('wallets', 'users.id', '=', 'wallets.user_id')->find($id);

    }


    public function customer_report_list(array $input)
    {
        $itemPerPage = array_key_exists('per_page',$input) && is_numeric($input['per_page']) ? $input['per_page'] : 20;
        $list = User::with(['bookings','reviews'])->select(['users.*'])
            ->when(!empty($input['search']), function ($query) use ($input) {
                $query->where('users.first_name', 'like', '%'.$input['search'].'%');
                $query->orWhere('users.last_name', 'like', '%'.$input['search'].'%');
            })->where('users.type','=','customer');
        return$list->paginate($itemPerPage);
    }
    public function customer_report_show($id)
    {
        return User::select('users.*')->with(['bookings','reviews'])
           ->find($id);

    }

}
