<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferService extends Model
{
   use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function offer(): ?BelongsTo
    {
        return $this->belongsTo(Offer::class,'offer_id');
    }
    public function service(): ?BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
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
