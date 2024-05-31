<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
  use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function vendor() :BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function bookings(): ?HasMany
    {
        return $this->hasMany(Booking::class, 'employee_id');

    }
    public function branches(): ?BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'employee_branches', 'employee_id', 'branch_id');

    }
     public function services(): ?BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'employee_services',  'employee_id','service_id');
    }

    public function breakHours(): ?HasMany
    {
        return $this->hasMany(OfficialHour::class,'model_id')->where('type','break');
    }
    public function officialHours(): ?HasMany
    {
        return $this->hasMany(OfficialHour::class,'model_id')->where('type','work');
    }
    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
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
