<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard_name = 'api';


    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['photo','name'];
    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/' . $this->attributes['image']) : null) : null;
    }
    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function vendor() :?BelongsTo
    {
        return $this->belongsTo(Vendor::class,'model_id','id');
    }
    public function branches() :?HasMany
    {
        return $this->hasMany(Branch::class,'user_id');
    }
    public function createdBy() :BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function wallet() :?HasOne
    {
        return $this->hasOne(Wallet::class,'user_id');
    }

    public function updatedBy() :BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }
    public function bookings() :?HasMany
    {
        return $this->hasMany(Booking::class,'user_id');
    }
    public function reviews(): ?HasMany
    {
        return $this->hasMany(Review::class, 'created_by');
    }
}
