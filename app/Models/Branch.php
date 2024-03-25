<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $appends = ['photo'];

    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/' . $this->attributes['image']) : null) : null;
    }

    public function vendor() :BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id')->where('vendor_id',auth()->user()->model_id);
    }

    public function officialHours(): ?HasMany
    {
        return $this->hasMany(OfficialHour::class,'model_id')->where('model_type',OfficialHour::TYPE_BRANCH);
    }
    public function images(): ?HasMany
    {
        return $this->hasMany(BranchImage::class,'branch_id');
    }
    public function manager(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'manager_id');
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
