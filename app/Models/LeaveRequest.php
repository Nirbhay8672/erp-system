<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'employee_leave_requests';
    protected $guarded = [];

    public function employee() : BelongsTo
    {
        return $this->belongsTo(User::class , 'employee_id' , 'id');
    }
}
