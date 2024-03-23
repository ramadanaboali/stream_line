<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBranch extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function branch(): ?BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id');
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
