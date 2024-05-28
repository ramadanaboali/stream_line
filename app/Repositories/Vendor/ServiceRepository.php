<?php

namespace App\Repositories\Vendor;

use App\Models\Service;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class ServiceRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Service::class);
    }


    public function createItem(array $data)
    {
        try {
            DB::beginTransaction();
            $input = [
                'name_en'=>$data['name_en'],
                'name_ar'=>$data['name_ar'],
                'description_en'=>$data['description_en'],
                'description_ar'=>$data['description_ar'],
                'section_id'=>$data['section_id'],
                'category_id'=>$data['category_id'],
                'sub_category_id'=>$data['sub_category_id'],
                'price'=>$data['price'],
                'service_time'=>$data['service_time'],
                'extra_time'=>$data['extra_time']??null,
                'featured'=>$data['featured'],
                'vendor_id' => auth()->user()->model_id,
                'created_by' => auth()->user()->id,
            ];
            $item = Service::create($input);
            $item->branches()->attach($data['branch_id']);
            if (key_exists('employee_id', $data)) {
                $item->employees()->attach($data['employee_id']);
            }
            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    public function updateItem($data,$item)
    {

        try {
            DB::beginTransaction();
            $input = [
                'name_en' => $data['name_en'] ?? $item->name_en,
                'name_ar' => $data['name_ar'] ?? $item->name_en,
                'description_en' => $data['description_en'] ?? $item->description_en,
                'description_ar' => $data['description_ar'] ?? $item->description_ar,
                'section_id' => $data['section_id'] ?? $item->section_id,
                'category_id' => $data['category_id'] ?? $item->category_id,
                'sub_category_id' => $data['sub_category_id'] ?? $item->sub_category_id,
                'price' => $data['price'] ?? $item->price,
                'service_time' => $data['service_time'] ?? $item->service_time,
                'extra_time' => $data['extra_time'] ?? $item->extra_time,
                'featured' => $data['featured'] ?? $item->featured,
                'discount_type' => $data['discount_type'] ?? $item->discount_type,
                'discount' => $data['discount'] ?? $item->discount,
                'is_active' => $data['is_active'] ?? $item->is_active,
                'updated_by' => auth()->user()->id,
            ];
            $item->update($input);
            if (key_exists('branch_id', $data)) {
                $item->branches()->detach();
                $item->branches()->attach($data['branch_id']);
            }
            if (key_exists('employee_id', $data)) {
                $item->employees()->detach();
                $item->employees()->attach($data['employee_id']);
            }
            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

    }
}
