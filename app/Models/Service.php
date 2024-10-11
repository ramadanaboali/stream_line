<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
   use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function vendor() :BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }
    public function category() :BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function section() :BelongsTo
    {
        return $this->belongsTo(Section::class,'section_id','id');
    }
    public function employees(): ?BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_services','service_id',  'employee_id');
    }
    public function branches(): ?BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'service_branches', 'service_id','branch_id');
    }
    public function createdBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function updatedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by');
    }
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_services', 'service_id', 'booking_id');
    }

}
