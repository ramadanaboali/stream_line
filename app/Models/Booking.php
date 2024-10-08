<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
//    protected $appends = ['customerInvoiceUrl','vendorInvoiceUrl'];
    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function branch(): ?BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function service(): ?BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function offer(): ?BelongsTo
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    public function promoCode(): ?BelongsTo
    {
        return $this->belongsTo(PromoCode::class, 'promocode_id');
    }
    public function createdBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function employee(): ?BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function updatedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function vendor(): ?BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function reviews(): ?HasMany
    {
        return $this->hasMany(Review::class, 'booking_id');
    }
//    public function getCustomerInvoiceUrlAttribute()
//    {
//        return array_key_exists('customer_invoice', $this->attributes) ? ($this->attributes['customer_invoice'] != null ? asset('storage/' . $this->attributes['customer_invoice']) : null) : null;
//
//    }
//    public function getVendorInvoiceUrlAttribute()
//    {
//        return array_key_exists('vendor_invoice', $this->attributes) ? ($this->attributes['vendor_invoice'] != null ? asset('storage/' . $this->attributes['vendor_invoice']) : null) : null;
//
//    }

}
