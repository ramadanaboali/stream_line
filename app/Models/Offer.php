<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function vendor() :BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }
    public function bookings(): ?HasMany
    {
        return $this->hasMany(Booking::class, 'offer_id');
    }
    public function services(): ?BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'offer_services',  'offer_id','service_id');
    }
    public function section(): ?BelongsTo
    {
        return $this->belongsTo(Section::class,'section_id');
    }
    public function category(): ?BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class,'category_id')->where('type','main');
    }
    public function sub_category(): ?BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class,'sub_category_id')->where('type','sub');
    }
    public function createdBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function updatedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by');
    }
}
