<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingService extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function service(): ?BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function booking(): ?BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
