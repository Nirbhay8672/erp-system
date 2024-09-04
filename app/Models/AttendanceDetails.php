<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceDetails extends Model
{
    use HasFactory;

    protected $table = 'employee_attendance_details';

    protected $casts = [
        'employee_id' => 'integer',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'time_different' => 'integer',
        'attendance_date' => 'date',
        'entry_type' => 'integer',
    ];

    protected $guarded = [];

    public function employee(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'employee_id', 'id');
    }
}
