<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpCenter extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $appends = ['photo','videoPath'];
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
    public function getVideoPathAttribute()
    {
        return array_key_exists('video', $this->attributes) ? ($this->attributes['video'] != null ? asset('storage/' . $this->attributes['video']) : null) : null;

    }
}
