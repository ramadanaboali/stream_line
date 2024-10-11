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
    protected $appends = ['average_rate'];
//    protected $appends = ['customerInvoiceUrl','vendorInvoiceUrl'];
    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function branch(): ?BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function bookingService(): ?HasMany
    {
        return $this->hasMany(BookingService::class, 'booking_id');
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
    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services', 'booking_id', 'service_id');
    }

    public function getAverageRateAttribute()
    {
        if ($this->reviews->count() > 0) {
            return $this->reviews->sum('service_rate')/$this->reviews->count('service_rate');
        }

        return 0;
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
