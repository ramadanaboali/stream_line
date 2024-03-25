<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeService extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function service(): ?BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function employee(): ?BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
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
