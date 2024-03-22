<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
  use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $appends = ['photo'];

    public function vendor(): ?BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id')->where('vendor_id',auth()->user()->model_id);
    }
    public function createdBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function updatedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by');
    }
    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/' . $this->attributes['image']) : null) : null;
    }

}
