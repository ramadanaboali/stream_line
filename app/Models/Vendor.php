<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
  use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $appends = ['average_rate'];
    public function vendorCategories():?BelongsToMany
    {
        return $this->belongsToMany(VendorCategory::class, 'vendor_categories','vendor_id','category_id');
    }

    public function bookings():?HasMany
    {
        return $this->hasMany(Booking::class, 'vendor_id','id');
    }
    public function services():?HasMany
    {
        return $this->hasMany(Service::class, 'vendor_id','id');
    }
    public function offers():?HasMany
    {
        return $this->hasMany(Offer::class, 'vendor_id','id');
    }
    public function branches():?HasMany
    {
        return $this->hasMany(Branch::class, 'vendor_id','id');
    }
    public function createdBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function user(): ?HasOne
    {
        return $this->hasOne(User::class,'model_id')->where('type','=',"vendor");
    }
//    public function user()
//    {
//        return User::where('model_id','=',$this->id)->where('type','=','vendor')->get();
//    }
    public function updatedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by');
    }
    public function getAverageRateAttribute()
    {
        $reviews = $this->bookings->load('reviews')->pluck('reviews.*.service_rate')->collapse()->filter();

        // Check if there are any reviews to calculate the average
        if ($reviews->count() > 0) {
            return $reviews->sum()/$reviews->count();
        }

        return 0;
    }
}
