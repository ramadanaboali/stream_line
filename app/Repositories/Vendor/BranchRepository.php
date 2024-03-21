<?php

namespace App\Repositories\Vendor;

use App\Models\Branch;
use App\Models\BranchImage;
use App\Models\OfficialHour;
use App\Repositories\AbstractRepository;
use App\Services\General\StorageService;

class BranchRepository extends AbstractRepository
{
    protected StorageService $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
        parent::__construct(Branch::class);
    }
    public function addImages($images, $id){

        foreach ($images as $image) {

            $folder_path = "images/branch";
            $data['image']= $this->storageService->storeFile($image, $folder_path);
            $data['branch_id']=$id;
            $data['created_by'] = auth()->user()->id;
            BranchImage::create($data);
        }
    }
    public function officialHours($officialHours, $id){
        foreach ($officialHours as $officialHour) {
            $data['start_time']=$officialHour['start_time'];
            $data['end_time']=$officialHour['end_time'];
            $data['day']=$officialHour['day'];
            $data['type']=OfficialHour::TYPE_BRANCH;
            $data['model_id']=$id;
            $data['created_by'] = auth()->user()->id;
            OfficialHour::create($data);
        }
    }

}
