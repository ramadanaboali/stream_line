<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    public function category(): ?BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function main_service_category(): ?BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class,'main_service_category_id');
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
