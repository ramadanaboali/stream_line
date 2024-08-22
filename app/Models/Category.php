<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $appends = ['image'];
     public function vendors()
    {
        return $this->belongsToMany(VendorCategory::class, 'vendor_categories','category_id','vendor_id');
    }
    public function createdBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function updatedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by');
    }
    public function getImageAttribute()
    {
        return array_key_exists('icon', $this->attributes) ? ($this->attributes['icon'] != null ? asset('storage/' . $this->attributes['icon']) : null) : null;

    }
}
